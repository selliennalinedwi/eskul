<?php
namespace App\Models;
use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'type',
        'filename',
        'original_filename',
        'file_path',
        'mime_type',
        'file_size',
        'width',
        'height',
        'aspect_ratio',
        'description',
        'is_public',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    /**
     * Type: profile, product, logo, gallery
     */

    public function getUserMedia($user_id, $type = null)
    {
        $query = $this->where('user_id', $user_id);

        if($type) {
            $query = $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'DESC')->findAll();
    }

    public function getPublicMedia($type = null, $limit = 20)
    {
        $query = $this->where('is_public', true);

        if($type) {
            $query = $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }

    public function deleteMedia($id)
    {
        $media = $this->find($id);
        
        if($media) {
            // Delete file dari storage
            if(file_exists($media['file_path'])) {
                unlink($media['file_path']);
            }

            // Delete dari database
            return $this->delete($id);
        }

        return false;
    }

    public function getMediaStats()
    {
        return [
            'total' => $this->countAll(),
            'profile' => $this->where('type', 'profile')->countAllResults(),
            'product' => $this->where('type', 'product')->countAllResults(),
            'logo' => $this->where('type', 'logo')->countAllResults(),
            'gallery' => $this->where('type', 'gallery')->countAllResults(),
        ];
    }
}
