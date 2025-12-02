<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Services\NotificationService;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    protected $userModel;
    protected $notificationService;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->userModel = new UserModel();
        $this->notificationService = new NotificationService();
        $this->session = session();
    }

    /**
     * Show notification settings page
     */
    public function settings()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $user_id = $this->session->get('user_id');
        $data['user'] = $this->userModel->find($user_id);

        echo view('layouts/header');
        echo view('profile/settings', $data);
        echo view('layouts/footer');
    }

    /**
     * Update notification settings
     */
    public function updateNotificationSettings()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $user_id = $this->session->get('user_id');

        // Validate phone number format if provided
        $phone = $this->request->getPost('phone_number');
        if ($phone && !preg_match('/^62[0-9]{9,12}$/', $phone)) {
            return redirect()->back()->with('error', 'Format nomor WhatsApp tidak valid. Gunakan format: 62XXXXXXXXXX');
        }

        try {
            $this->userModel->update($user_id, [
                'phone_number' => $phone ?: null,
                'notification_email' => $this->request->getPost('notification_email') ?: null,
            ]);

            return redirect()->back()->with('success', 'Pengaturan notifikasi berhasil disimpan');
        } catch (\Throwable $e) {
            log_message('error', 'Update settings error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Test WhatsApp notification (AJAX)
     */
    public function testWhatsApp()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $phone = $this->request->getJSON()->phone_number ?? null;

        if (!$phone || !preg_match('/^62[0-9]{9,12}$/', $phone)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format nomor WhatsApp tidak valid'
            ]);
        }

        try {
            // Send test message
            $this->notificationService->sendWhatsApp(
                $phone,
                "Halo! 👋\n\nIni adalah pesan test dari sistem Early Warning.\nNomor WhatsApp Anda telah berhasil terdaftar untuk menerima notifikasi.\n\n📱 Nomor: $phone\n⏰ Waktu: " . date('Y-m-d H:i:s')
            );

            return $this->response->setJSON(['success' => true]);
        } catch (\Throwable $e) {
            log_message('error', 'WhatsApp test error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Test Email notification (AJAX)
     */
    public function testEmail()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $email = $this->request->getJSON()->email ?? null;

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email tidak valid'
            ]);
        }

        try {
            $subject = 'Test Notifikasi - Ekskul Online';
            $message = "Halo!\n\nIni adalah email test dari sistem Early Warning.\nEmail Anda telah berhasil terdaftar untuk menerima notifikasi.\n\n📧 Email: $email\n⏰ Waktu: " . date('Y-m-d H:i:s');

            $this->notificationService->sendEmail($email, $subject, $message);

            return $this->response->setJSON(['success' => true]);
        } catch (\Throwable $e) {
            log_message('error', 'Email test error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
