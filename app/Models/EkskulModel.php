<?php
namespace App\Models;
use CodeIgniter\Model;

class EkskulModel extends Model
{
    protected $table = 'ekskuls';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'description', 'capacity', 'hari', 'jam_mulai', 'jam_selesai', 'guru_id'];
    protected $useTimestamps = true;

    /**
     * Ambil jadwal ekskul untuk guru tertentu
     * @param int $guru_id
     * @return array
     */
    public function getSchedule($guru_id)
    {
        return $this->where('guru_id', $guru_id)
            ->orderBy('hari', 'ASC')
            ->findAll();
    }
}
