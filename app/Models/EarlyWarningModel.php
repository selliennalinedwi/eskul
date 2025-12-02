<?php
namespace App\Models;
use CodeIgniter\Model;

class EarlyWarningModel extends Model
{
    protected $table = 'early_warnings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id',
        'type',
        'title',
        'description',
        'severity',
        'status',
        'sent_at',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    /**
     * Tipe warning
     * - attendance: kehadiran rendah
     * - performance: nilai rendah
     * - behavior: perilaku kurang baik
     * - dropout_risk: risiko keluar
     */
    
    public function getStudentWarnings($student_id)
    {
        return $this->where('student_id', $student_id)
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getActiveWarnings()
    {
        return $this->where('status', 'active')
            ->where('sent_at', null)
            ->findAll();
    }

    public function checkAttendanceWarning($student_id, $attendance_percentage = 75)
    {
        // Cek jika kehadiran di bawah 75%
        if($attendance_percentage < 75) {
            $existing = $this->where('student_id', $student_id)
                ->where('type', 'attendance')
                ->where('status', 'active')
                ->first();

            if(!$existing) {
                $this->insert([
                    'student_id' => $student_id,
                    'type' => 'attendance',
                    'title' => 'Kehadiran Rendah',
                    'description' => 'Persentase kehadiran siswa ' . $attendance_percentage . '% di bawah standar 75%',
                    'severity' => 'high'
                ]);
                return true;
            }
        }
        return false;
    }

    public function checkPerformanceWarning($student_id, $average_score = 70)
    {
        // Cek jika nilai rata-rata di bawah 70
        if($average_score < 70) {
            $existing = $this->where('student_id', $student_id)
                ->where('type', 'performance')
                ->where('status', 'active')
                ->first();

            if(!$existing) {
                $this->insert([
                    'student_id' => $student_id,
                    'type' => 'performance',
                    'title' => 'Performa Akademik Rendah',
                    'description' => 'Nilai rata-rata siswa ' . $average_score . ' di bawah standar 70',
                    'severity' => 'medium'
                ]);
                return true;
            }
        }
        return false;
    }
}
