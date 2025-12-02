<?php
namespace App\Controllers;
use App\Models\EkskulModel;
use App\Models\RegistrationModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    protected $ekskulModel;
    protected $registrationModel;
    protected $session;

    public function __construct()
    {
        helper(['form','url','session']);
        $this->ekskulModel = new EkskulModel();
        $this->registrationModel = new RegistrationModel();
        $this->session = session();

        // Cek role admin
        if(!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin'){
            redirect()->to('/auth/login')->send();
        }
    }

    // Dashboard admin
    public function index()
    {
        $data['registrations'] = $this->registrationModel->join('ekskuls','registrations.ekskul_id = ekskuls.id')
            ->join('users','registrations.user_id = users.id')
            ->select('registrations.*, ekskuls.title as ekskul_title, users.username as student_name')
            ->findAll();

        $data['ekskuls'] = $this->ekskulModel->findAll();

        echo view('layouts/header');
        echo view('admin/dashboard', $data);
        echo view('layouts/footer');
    }

    // Approve pendaftaran
    public function approve($id)
    {
        $this->registrationModel->update($id, ['status'=>'approved']);
        return redirect()->back()->with('success','Pendaftaran disetujui');
    }

    // Reject pendaftaran
    public function reject($id)
    {
        $this->registrationModel->update($id, ['status'=>'rejected']);
        return redirect()->back()->with('success','Pendaftaran ditolak');
    }

    // Tambah ekskul
    public function addEkskul()
    {
        echo view('layouts/header');
        echo view('admin/add_ekskul');
        echo view('layouts/footer');
    }

    public function addEkskulPost()
    {
        $this->ekskulModel->insert([
            'title'=>$this->request->getPost('title'),
            'slug'=>url_title($this->request->getPost('title'),'dash',true),
            'description'=>$this->request->getPost('description'),
            'capacity'=>$this->request->getPost('capacity')
        ]);
        return redirect()->to('/admin')->with('success','Ekskul berhasil ditambahkan');
    }

    // Edit ekskul
    public function editEkskul($id)
    {
        $data['ekskul'] = $this->ekskulModel->find($id);
        echo view('layouts/header');
        echo view('admin/edit_ekskul', $data);
        echo view('layouts/footer');
    }

    public function editEkskulPost($id)
    {
        $this->ekskulModel->update($id, [
            'title'=>$this->request->getPost('title'),
            'slug'=>url_title($this->request->getPost('title'),'dash',true),
            'description'=>$this->request->getPost('description'),
            'capacity'=>$this->request->getPost('capacity')
        ]);
        return redirect()->to('/admin')->with('success','Ekskul berhasil diperbarui');
    }

    // Hapus ekskul
    public function deleteEkskul($id)
    {
        $this->ekskulModel->delete($id);
        return redirect()->to('/admin')->with('success','Ekskul berhasil dihapus');
    }
    public function dashboard()
{
    // Semua pendaftaran
    $data['registrations'] = $this->registrationModel
        ->join('ekskuls','registrations.ekskul_id = ekskuls.id')
        ->join('users','registrations.user_id = users.id')
        ->select('registrations.*, ekskuls.title as ekskul_title, users.username as student_name')
        ->findAll();

    // Semua ekskul
    $data['ekskuls'] = $this->ekskulModel->findAll();

    // Statistik peserta per ekskul
    $stats = [];
    foreach($data['ekskuls'] as $eks){
        $count = $this->registrationModel->where('ekskul_id',$eks['id'])->countAllResults();
        $stats[] = ['title'=>$eks['title'],'count'=>$count];
    }
    $data['stats'] = $stats;

    echo view('layouts/header');
    echo view('admin/dashboard_chart', $data);
    echo view('layouts/footer');
}

}
