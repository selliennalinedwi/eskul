<?php
namespace App\Controllers;

use App\Models\EkskulModel;
use App\Models\RegistrationModel;
use App\Models\EarlyWarningModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    protected $ekskulModel;
    protected $registrationModel;
    protected $earlyWarningModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->ekskulModel = new EkskulModel();
        $this->registrationModel = new RegistrationModel();
        $this->earlyWarningModel = new EarlyWarningModel();
        $this->userModel = new UserModel();
        $this->session = session();
    }

    /**
     * Unified Dashboard - Routes to correct dashboard based on role
     */
    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $role = $this->session->get('role');

        switch ($role) {
            case 'admin':
                return $this->adminDashboard();
            case 'guru':
                return $this->guruDashboard();
            case 'siswa':
                return $this->siswaDashboard();
            default:
                return redirect()->to('/auth/login');
        }
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        // Check permission
        if ($this->session->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai admin');
        }

        // Get data for admin
        $data['registrations'] = $this->registrationModel
            ->join('ekskuls', 'registrations.ekskul_id = ekskuls.id')
            ->join('users', 'registrations.user_id = users.id')
            ->select('registrations.*, ekskuls.title as ekskul_title, users.username as student_name')
            ->findAll();

        $data['ekskuls'] = $this->ekskulModel->findAll();
        
        // Statistics
        $data['pending'] = count(array_filter($data['registrations'], fn($r) => $r['status'] === 'pending'));
        $data['approved'] = count(array_filter($data['registrations'], fn($r) => $r['status'] === 'approved'));
        $data['rejected'] = count(array_filter($data['registrations'], fn($r) => $r['status'] === 'rejected'));

        echo view('layouts/header');
        echo view('dashboard/admin', $data);
        echo view('layouts/footer');
    }

    /**
     * Guru Dashboard
     */
    private function guruDashboard()
    {
        // Check permission
        if ($this->session->get('role') !== 'guru') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai guru');
        }

        $guru_id = $this->session->get('user_id');

        // Get data for guru
        $data['total_siswa'] = $this->userModel->where('role', 'siswa')->countAllResults();
        $data['ekskuls_count'] = $this->ekskulModel->countAllResults();
        $data['registrations'] = $this->registrationModel
            ->join('ekskuls', 'registrations.ekskul_id = ekskuls.id')
            ->join('users', 'registrations.user_id = users.id')
            ->select('registrations.*, ekskuls.title as ekskul_title, users.username as student_name')
            ->limit(5)
            ->findAll();

        // Early warnings for guru
        $data['warnings'] = $this->earlyWarningModel
            ->select('early_warnings.*, users.username as student_name')
            ->join('users', 'users.id = early_warnings.student_id')
            ->where('early_warnings.status', 'active')
            ->orderBy('early_warnings.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        echo view('layouts/header');
        echo view('dashboard/guru', $data);
        echo view('layouts/footer');
    }

    /**
     * Siswa Dashboard
     */
    private function siswaDashboard()
    {
        // Check permission
        if ($this->session->get('role') !== 'siswa') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai siswa');
        }

        $siswa_id = $this->session->get('user_id');
        $student_data = $this->userModel->find($siswa_id);

        // Get data for siswa
        $data['my_registrations'] = $this->registrationModel
            ->join('ekskuls', 'registrations.ekskul_id = ekskuls.id')
            ->select('registrations.*, ekskuls.title, ekskuls.description, ekskuls.image')
            ->where('registrations.user_id', $siswa_id)
            ->findAll();

        $data['my_warnings'] = $this->earlyWarningModel
            ->where('student_id', $siswa_id)
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data['total_ekskul'] = $this->ekskulModel->countAllResults();
        $data['student_data'] = $student_data;

        echo view('layouts/header');
        echo view('dashboard/siswa', $data);
        echo view('layouts/footer');
    }
}
