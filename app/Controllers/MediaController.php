<?php
namespace App\Controllers;

use App\Models\MediaModel;
use App\Services\ImageUploadService;
use CodeIgniter\Controller;

class MediaController extends Controller
{
    protected $mediaModel;
    protected $imageService;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->mediaModel = new MediaModel();
        $this->imageService = new ImageUploadService();
        $this->session = session();
    }

    /**
     * Dashboard galeri media
     */
    public function gallery()
    {
        if(!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $user_id = $this->session->get('user_id');
        $type = $this->request->getGet('type');

        $data['media'] = $this->mediaModel->getUserMedia($user_id, $type);
        $data['stats'] = $this->mediaModel->getMediaStats();
        $data['current_type'] = $type;

        echo view('layouts/header');
        echo view('media/gallery', $data);
        echo view('layouts/footer');
    }

    /**
     * Form upload foto
     */
    public function uploadForm()
    {
        if(!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data['aspectRatios'] = $this->imageService->getAspectRatios();

        echo view('layouts/header');
        echo view('media/upload_form', $data);
        echo view('layouts/footer');
    }

    /**
     * Store upload foto
     */
    public function upload()
    {
        if(!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $file = $this->request->getFile('photo');
        $type = $this->request->getPost('type') ?? 'gallery';
        $aspect_ratio = $this->request->getPost('aspect_ratio') ?? 'square';
        $description = $this->request->getPost('description') ?? '';
        $user_id = $this->session->get('user_id');

        // Upload gambar
        $uploadResult = $this->imageService->upload($file, $type, $aspect_ratio, $user_id, $description);

        if(!$uploadResult['status']) {
            return redirect()->back()->with('error', $uploadResult['message']);
        }

        // Simpan ke database
        $mediaData = $uploadResult['data'];
        $mediaData['user_id'] = $user_id;

        $this->mediaModel->insert($mediaData);

        return redirect()->to('/media/gallery')->with('success', 'Foto berhasil diupload: ' . $uploadResult['message']);
    }

    /**
     * View foto detail
     */
    public function viewPhoto($id)
    {
        $photo = $this->mediaModel->find($id);

        if(!$photo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Foto tidak ditemukan');
        }

        // Check permission
        if($photo['user_id'] !== $this->session->get('user_id') && !$photo['is_public']) {
            if($this->session->get('role') !== 'admin') {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Akses ditolak');
            }
        }

        $data['photo'] = $photo;

        echo view('layouts/header');
        echo view('media/view_photo', $data);
        echo view('layouts/footer');
    }

    /**
     * Delete foto
     */
    public function deletePhoto($id)
    {
        if(!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $photo = $this->mediaModel->find($id);

        if(!$photo) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan');
        }

        // Check permission
        if($photo['user_id'] !== $this->session->get('user_id')) {
            if($this->session->get('role') !== 'admin') {
                return redirect()->back()->with('error', 'Akses ditolak');
            }
        }

        // Delete file
        $this->imageService->deleteImage($photo['file_path']);

        // Delete dari database
        $this->mediaModel->delete($id);

        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }

    /**
     * Update visibility
     */
    public function updateVisibility($id)
    {
        $user_id = $this->session->get('user_id');
        $photo = $this->mediaModel->find($id);

        if(!$photo || $photo['user_id'] !== $user_id) {
            return $this->response->setStatusCode(403)->setJSON(['status' => false, 'message' => 'Akses ditolak']);
        }

        $is_public = $this->request->getPost('is_public') ? 1 : 0;
        $this->mediaModel->update($id, ['is_public' => $is_public]);

        return $this->response->setJSON(['status' => true, 'message' => 'Visibilitas diperbarui']);
    }

    /**
     * AJAX: Upload dengan preview
     */
    public function uploadAjax()
    {
        if(!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        if(!$this->session->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setJSON(['status' => false, 'message' => 'Not authenticated']);
        }

        $file = $this->request->getFile('photo');
        $type = $this->request->getPost('type') ?? 'gallery';
        $aspect_ratio = $this->request->getPost('aspect_ratio') ?? 'square';
        $description = $this->request->getPost('description') ?? '';
        $user_id = $this->session->get('user_id');

        $uploadResult = $this->imageService->upload($file, $type, $aspect_ratio, $user_id, $description);

        if(!$uploadResult['status']) {
            return $this->response->setJSON($uploadResult);
        }

        // Simpan ke database
        $mediaData = $uploadResult['data'];
        $mediaData['user_id'] = $user_id;
        $mediaId = $this->mediaModel->insert($mediaData);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Foto berhasil diupload',
            'data' => array_merge($mediaData, ['id' => $mediaId]),
            'filepath' => base_url($uploadResult['filepath'])
        ]);
    }

    /**
     * Settings media
     */
    public function settings()
    {
        if($this->session->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $data['stats'] = $this->imageService->getStorageStats();
        $data['aspectRatios'] = $this->imageService->getAspectRatios();

        echo view('layouts/header');
        echo view('media/settings', $data);
        echo view('layouts/footer');
    }
}
