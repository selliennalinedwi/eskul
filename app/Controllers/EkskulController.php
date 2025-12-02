<?php
namespace App\Controllers;
use App\Models\EkskulModel;
use App\Models\RegistrationModel;
use CodeIgniter\Controller;

class EkskulController extends Controller
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
    }

    public function index()
    {
        $data['ekskuls'] = $this->ekskulModel->findAll();
        echo view('layouts/header');
        echo view('ekskul/index',$data);
        echo view('layouts/footer');
    }

    public function detail($slug = null)
    {
        if(!$slug) return redirect()->to('/ekskul');
        $item = $this->ekskulModel->where('slug',$slug)->first();
        if(!$item) return redirect()->to('/ekskul');

        echo view('layouts/header');
        echo view('ekskul/detail',['item'=>$item]);
        echo view('layouts/footer');
    }

    public function register()
    {
        if(!$this->session->has('user_id')){
            return redirect()->to('/auth/login');
        }

        $rules = [
            'ekskul_id'=>'required|integer',
            'student_name'=>'required|min_length[3]'
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        }

        $this->registrationModel->insert([
            'user_id'=>$this->session->get('user_id'),
            'ekskul_id'=>$this->request->getPost('ekskul_id'),
            'form_data'=>json_encode($this->request->getPost()),
            'status'=>'pending'
        ]);

        return redirect()->to('/ekskul')->with('success','Pendaftaran berhasil, menunggu verifikasi admin.');
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        if($keyword){
            $data['ekskuls'] = $this->ekskulModel
                ->like('title',$keyword)
                ->orLike('description',$keyword)
                ->findAll();
        }else{
            $data['ekskuls'] = $this->ekskulModel->findAll();
        }

        echo view('layouts/header');
        echo view('ekskul/index',$data);
        echo view('layouts/footer');
    }
}
