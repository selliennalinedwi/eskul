<?php
namespace App\Controllers;

use App\Models\EarlyWarningModel;
use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Services\NotificationService;
use CodeIgniter\Controller;

class EarlyWarningController extends Controller
{
    protected $warningModel;
    protected $notificationModel;
    protected $userModel;
    protected $notificationService;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->warningModel = new EarlyWarningModel();
        $this->notificationModel = new NotificationModel();
        $this->userModel = new UserModel();
        $this->notificationService = new NotificationService();
        $this->session = session();
    }

    /**
     * Dashboard early warning (untuk admin/guru)
     */
    public function dashboard()
    {
        $role = $this->session->get('role');
        $user_id = $this->session->get('user_id');

        if($role === 'admin') {
            // Admin melihat semua warning
            $data['warnings'] = $this->warningModel
                ->select('early_warnings.*, users.username as student_name, users.email')
                ->join('users', 'users.id = early_warnings.student_id')
                ->where('early_warnings.status', 'active')
                ->orderBy('early_warnings.severity', 'DESC')
                ->orderBy('early_warnings.created_at', 'DESC')
                ->findAll();
        } else {
            // Guru melihat warning siswa dibimbingnya
            // Sesuaikan dengan logika guru anda
            $data['warnings'] = [];
        }

        echo view('layouts/header');
        echo view('early_warning/dashboard', $data);
        echo view('layouts/footer');
    }

    /**
     * Create warning manual
     */
    public function createWarning()
    {
        echo view('layouts/header');
        echo view('early_warning/create_warning');
        echo view('layouts/footer');
    }

    /**
     * Store warning
     */
    public function storeWarning()
    {
        $rules = [
            'student_id' => 'required|is_not_empty',
            'type' => 'required|in_list[attendance,performance,behavior,dropout_risk]',
            'title' => 'required|min_length[5]',
            'description' => 'required|min_length[10]',
            'severity' => 'required|in_list[low,medium,high]'
        ];

        if(!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $student_id = $this->request->getPost('student_id');
        $send_notification = $this->request->getPost('send_notification');

        // Insert warning
        $this->warningModel->insert([
            'student_id' => $student_id,
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'severity' => $this->request->getPost('severity')
        ]);

        // Kirim notifikasi jika dipilih
        if($send_notification) {
            $student = $this->userModel->find($student_id);
            if($student) {
                $warning_data = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'severity' => $this->request->getPost('severity')
                ];

                $channels = [];
                if($this->request->getPost('notify_email')) $channels[] = 'email';
                if($this->request->getPost('notify_whatsapp')) $channels[] = 'whatsapp';

                $this->notificationService->sendEarlyWarning($student, $warning_data, $channels);
            }
        }

        return redirect()->to('/early-warning')->with('success', 'Warning berhasil dibuat');
    }

    /**
     * Check attendance dan create warning otomatis
     */
    public function checkAttendance()
    {
        // Implementasi untuk check attendance dari database
        // Sesuaikan dengan struktur tabel anda
        
        $students = $this->userModel->where('role', 'siswa')->findAll();

        foreach($students as $student) {
            // Hitung attendance percentage
            // $attendance_percentage = ...;
            // $this->warningModel->checkAttendanceWarning($student['id'], $attendance_percentage);
        }

        return redirect()->back()->with('success', 'Pengecekan kehadiran selesai');
    }

    /**
     * Send all pending notifications
     */
    public function sendPendingNotifications()
    {
        $pending = $this->notificationModel->getPendingNotifications();

        foreach($pending as $notif) {
            $sent = false;

            if($notif['channel'] === 'email') {
                $result = $this->notificationService->sendEmail(
                    $notif['recipient'],
                    $notif['subject'],
                    $notif['message']
                );
                $sent = $result['status'];
            } elseif($notif['channel'] === 'whatsapp') {
                $result = $this->notificationService->sendWhatsApp(
                    $notif['recipient'],
                    $notif['message']
                );
                $sent = $result['status'];
            }

            if($sent) {
                $this->notificationModel->markAsSent($notif['id']);
            }
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim');
    }

    /**
     * View warning detail
     */
    public function viewWarning($id)
    {
        $data['warning'] = $this->warningModel
            ->select('early_warnings.*, users.username as student_name, users.email')
            ->join('users', 'users.id = early_warnings.student_id')
            ->where('early_warnings.id', $id)
            ->first();

        if(!$data['warning']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warning not found');
        }

        echo view('layouts/header');
        echo view('early_warning/view_warning', $data);
        echo view('layouts/footer');
    }

    /**
     * Mark warning as resolved
     */
    public function resolveWarning($id)
    {
        $this->warningModel->update($id, ['status' => 'resolved']);
        return redirect()->back()->with('success', 'Warning ditandai sebagai terselesaikan');
    }

    /**
     * Get students list for dropdown (AJAX endpoint)
     */
    public function getStudents()
    {
        $students = $this->userModel->where('role', 'siswa')->select('id, username, email')->findAll();
        return $this->response->setJSON($students);
    }
}
