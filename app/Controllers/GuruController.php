<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegistrationModel; // model pendaftaran ekskul
use App\Models\EkskulModel;       // model ekskul

class GuruController extends Controller
{
    protected $registrationModel;
    protected $ekskulModel;
    protected $session;

    public function __construct()
    {
        helper(['url','form','session']);
        $this->registrationModel = new RegistrationModel();
        $this->ekskulModel = new EkskulModel();
        $this->session = session();

        // cek login & role
        if(!$this->session->get('isLoggedIn') || $this->session->get('role') != 'guru'){
            return redirect()->to('/auth/login')->send();
            exit;
        }
    }

    // Dashboard guru
    public function dashboard()
    {
        $guru_id = $this->session->get('user_id');

        // ambil semua murid yang daftar ekskul dibimbing guru ini
        $murid = $this->registrationModel
            ->select('registrations.*, ekskul.title as ekskul')
            ->join('ekskul','ekskul.id = registrations.ekskul_id')
            ->where('ekskul.guru_id', $guru_id)
            ->orderBy('registrations.id','ASC')
            ->findAll();

        // ambil jadwal ekskul guru
        $schedule = $this->ekskulModel
            ->where('guru_id', $guru_id)
            ->orderBy('hari','ASC')
            ->findAll();

        // kirim data ke view
        $data = [
            'murid' => $murid,
            'schedule' => $schedule
        ];

        echo view('layouts/header');
        echo view('guru/dashboard', $data);
        echo view('layouts/footer');
    }
}
