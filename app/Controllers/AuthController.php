<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        helper(['form','url','session']);
        $this->userModel = new UserModel();
        $this->session = session();
    }

    // Tampilkan form login
    public function login()
    {
        echo view('layouts/header');
        echo view('auth/login');
        echo view('layouts/footer');
    }

    // Proses login
    public function loginPost()
    {
        $rules = [
            'email'=>'required|valid_email',
            'password'=>'required|min_length[3]'
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        }

        $user = $this->userModel->where('email',$this->request->getPost('email'))->first();

        if($user && password_verify($this->request->getPost('password'), $user['password'])){
            // Set session
            $this->session->set([
                'user_id'=>$user['id'],
                'user_name'=>$user['username'],
                'role'=>$user['role'],
                'isLoggedIn'=>true
            ]);

            // Redirect sesuai role
            switch($user['role']){
                case 'admin':
                    return redirect()->to('/admin/dashboard');
                case 'guru':
                    return redirect()->to('/guru/dashboard');
                case 'siswa':
                    return redirect()->to('/ekskul');
                default:
                    return redirect()->to('/');
            }

        }else{
            return redirect()->back()->with('error','Email atau password salah');
        }
    }

    // Tampilkan form register
    public function register()
    {
        echo view('layouts/header');
        echo view('auth/register');
        echo view('layouts/footer');
    }

    // Proses register
    public function registerPost()
    {
        $rules = [
            'username'=>'required|min_length[3]',
            'email'=>'required|valid_email|is_unique[users.email]',
            'password'=>'required|min_length[3]',
            'password_confirm'=>'matches[password]'
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        }

        try {
            $result = $this->userModel->insert([
                'username'=>$this->request->getPost('username'),
                'email'=>$this->request->getPost('email'),
                'password'=>password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'=>'siswa' // default role siswa
            ]);

            if($result) {
                return redirect()->to('/auth/login')->with('success','Registrasi berhasil. Silakan login.');
            } else {
                return redirect()->back()->withInput()->with('error','Gagal menyimpan data. Silakan coba lagi.');
            }
        } catch(\Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error','Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login');
    }
}
