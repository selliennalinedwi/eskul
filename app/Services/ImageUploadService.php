<?php
namespace App\Services;

use Config\Services;

class ImageUploadService
{
    protected $uploadPath = 'uploads/media/';
    protected $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    protected $maxFileSize = 5242880; // 5MB

    /**
     * Aspect ratios seperti Instagram
     * - square: 1:1
     * - portrait: 4:5
     * - landscape: 16:9
     * - full: 1:1 (default)
     */
    protected $aspectRatios = [
        'square' => ['width' => 1080, 'height' => 1080, 'ratio' => 1],
        'portrait' => ['width' => 1080, 'height' => 1350, 'ratio' => 0.8],
        'landscape' => ['width' => 1200, 'height' => 675, 'ratio' => 16/9],
        'story' => ['width' => 1080, 'height' => 1920, 'ratio' => 0.5625],
    ];

    public function __construct()
    {
        // Pastikan upload directory ada
        if(!is_dir(FCPATH . $this->uploadPath)) {
            mkdir(FCPATH . $this->uploadPath, 0755, true);
        }
    }

    /**
     * Upload foto dengan resize dan crop
     * 
     * @param $file - File dari request
     * @param $type - Type: profile, product, logo, gallery
     * @param $aspect_ratio - Aspect ratio: square, portrait, landscape, story
     * @param $user_id - User ID
     * @return array|false
     */
    public function upload($file, $type = 'gallery', $aspect_ratio = 'square', $user_id = null, $description = '')
    {
        try {
            // Validasi file
            if(!$file->isValid()) {
                return ['status' => false, 'message' => 'File tidak valid'];
            }

            if(!in_array($file->getMimeType(), $this->allowedMimes)) {
                return ['status' => false, 'message' => 'Tipe file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP'];
            }

            if($file->getSize() > $this->maxFileSize) {
                return ['status' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 5MB'];
            }

            // Buat nama file unik
            $filename = $this->generateFilename($file);
            $filepath = FCPATH . $this->uploadPath . $filename;

            // Move file ke folder temporary
            $file->move(FCPATH . $this->uploadPath, $filename);

            // Resize dan crop image
            $imageData = $this->processImage($filepath, $aspect_ratio);

            if(!$imageData) {
                unlink($filepath);
                return ['status' => false, 'message' => 'Gagal memproses gambar'];
            }

            // Create thumbnail
            $this->createThumbnail($filepath, $aspect_ratio);

            // Simpan ke database (opsional)
            $mediaData = [
                'user_id' => $user_id,
                'type' => $type,
                'filename' => $filename,
                'original_filename' => $file->getClientName(),
                'file_path' => $this->uploadPath . $filename,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'width' => $imageData['width'],
                'height' => $imageData['height'],
                'aspect_ratio' => $aspect_ratio,
                'description' => $description,
                'is_public' => 0
            ];

            return [
                'status' => true,
                'message' => 'Gambar berhasil diupload',
                'data' => $mediaData,
                'filepath' => $this->uploadPath . $filename
            ];

        } catch(\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Process gambar dengan crop dan resize sesuai aspect ratio
     */
    private function processImage($filepath, $aspect_ratio = 'square')
    {
        try {
            $image = Services::image()
                ->withFile($filepath);

            $originalWidth = $image->getWidth();
            $originalHeight = $image->getHeight();

            $targetRatio = $this->aspectRatios[$aspect_ratio] ?? $this->aspectRatios['square'];

            // Hitung dimensi untuk crop
            list($cropWidth, $cropHeight) = $this->calculateCropDimensions(
                $originalWidth,
                $originalHeight,
                $targetRatio['ratio']
            );

            // Calculate position untuk center crop
            $cropX = ($originalWidth - $cropWidth) / 2;
            $cropY = ($originalHeight - $cropHeight) / 2;

            // Crop image
            $image->crop($cropWidth, $cropHeight, $cropX, $cropY);

            // Resize ke target size
            $image->resize($targetRatio['width'], $targetRatio['height'], true);

            // Simpan hasil
            $image->save($filepath);

            return [
                'width' => $targetRatio['width'],
                'height' => $targetRatio['height'],
                'aspect_ratio' => $aspect_ratio
            ];

        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Create thumbnail
     */
    private function createThumbnail($filepath, $aspect_ratio = 'square')
    {
        try {
            $thumbnailPath = str_replace('.', '_thumb.', $filepath);

            $image = Services::image()
                ->withFile($filepath);

            // Resize ke 300x300 atau sesuai aspect ratio
            $image->resize(300, 300, true);
            $image->save($thumbnailPath);

            return $thumbnailPath;

        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Hitung dimensi crop berdasarkan aspect ratio
     */
    private function calculateCropDimensions($width, $height, $targetRatio)
    {
        $currentRatio = $width / $height;

        if($currentRatio > $targetRatio) {
            // Gambar lebih lebar, potong samping
            $cropWidth = $height * $targetRatio;
            $cropHeight = $height;
        } else {
            // Gambar lebih tinggi, potong atas/bawah
            $cropWidth = $width;
            $cropHeight = $width / $targetRatio;
        }

        return [round($cropWidth), round($cropHeight)];
    }

    /**
     * Generate filename unik
     */
    private function generateFilename($file)
    {
        $name = pathinfo($file->getClientName(), PATHINFO_FILENAME);
        $ext = pathinfo($file->getClientName(), PATHINFO_EXTENSION);

        // Remove special characters
        $name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);

        return $name . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    }

    /**
     * Get aspect ratios
     */
    public function getAspectRatios()
    {
        return $this->aspectRatios;
    }

    /**
     * Delete image
     */
    public function deleteImage($filepath)
    {
        try {
            if(file_exists(FCPATH . $filepath)) {
                unlink(FCPATH . $filepath);
            }

            // Delete thumbnail
            $thumbnailPath = str_replace('.', '_thumb.', FCPATH . $filepath);
            if(file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }

            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Compress image
     */
    public function compressImage($filepath, $quality = 80)
    {
        try {
            $image = Services::image()
                ->withFile(FCPATH . $filepath);

            $image->save(FCPATH . $filepath, $quality);

            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Get storage stats
     */
    public function getStorageStats()
    {
        $uploadDir = FCPATH . $this->uploadPath;
        $totalSize = 0;
        $fileCount = 0;

        if(is_dir($uploadDir)) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($uploadDir));
            
            foreach($files as $file) {
                if($file->isFile()) {
                    $totalSize += $file->getSize();
                    $fileCount++;
                }
            }
        }

        return [
            'total_files' => $fileCount,
            'total_size' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2)
        ];
    }
}
