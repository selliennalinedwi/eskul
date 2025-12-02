<?php
namespace App\Models;
use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'email'];

    // Ambil jadwal guru
    public function getSchedule($guru_id)
    {
        return $this->db->table('jadwal')
            ->where('guru_id', $guru_id)
            ->orderBy('hari','ASC')
            ->get()
            ->getResultArray();
    }

    // Ambil list murid di ekskul yang dia ampu
    public function getMuridByEkskul($guru_id)
    {
        return $this->db->table('registrations r')
            ->select('r.id, r.form_data, e.title as ekskul')
            ->join('ekskul e','e.id = r.ekskul_id')
            ->join('guru g','g.id = e.guru_id')
            ->where('g.id', $guru_id)
            ->get()
            ->getResultArray();
    }
}
