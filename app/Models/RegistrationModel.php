<?php
namespace App\Models;
use CodeIgniter\Model;

class RegistrationModel extends Model
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','ekskul_id','form_data','status','validation_status','validation_message'];
    protected $useTimestamps = true;

    /**
     * Ambil semua murid yang daftar ekskul dibimbing oleh guru tertentu
     * @param int $guru_id
     * @return array
     */
    public function getMuridByGuru($guru_id)
    {
        return $this->select('registrations.*, users.username as student_name, users.email, ekskul.title as ekskul')
            ->join('users','users.id = registrations.user_id')
            ->join('ekskul','ekskul.id = registrations.ekskul_id')
            ->where('ekskul.guru_id', $guru_id)
            ->orderBy('registrations.created_at','ASC')
            ->findAll();
    }
}
