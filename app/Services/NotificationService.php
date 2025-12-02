<?php
namespace App\Services;

class NotificationService
{
    protected $emailService;
    protected $whatsappService;

    public function __construct()
    {
        $this->emailService = new EmailNotificationService();
        $this->whatsappService = new WhatsAppNotificationService();
    }

    /**
     * Kirim notifikasi melalui email
     */
    public function sendEmail($to, $subject, $message, $html = true)
    {
        return $this->emailService->send($to, $subject, $message, $html);
    }

    /**
     * Kirim notifikasi melalui WhatsApp
     */
    public function sendWhatsApp($phone, $message)
    {
        return $this->whatsappService->send($phone, $message);
    }

    /**
     * Kirim notifikasi ke multiple channels
     */
    public function sendMultiChannel($recipient, $subject, $message, $channels = ['email', 'whatsapp'])
    {
        $results = [];

        if(in_array('email', $channels)) {
            $results['email'] = $this->sendEmail($recipient['email'], $subject, $message);
        }

        if(in_array('whatsapp', $channels)) {
            $results['whatsapp'] = $this->sendWhatsApp($recipient['phone'], $message);
        }

        return $results;
    }

    /**
     * Kirim early warning ke orang tua/siswa
     */
    public function sendEarlyWarning($student_data, $warning_data, $channels = ['email', 'whatsapp'])
    {
        $subject = "Peringatan Dini: " . $warning_data['title'];
        
        $message = $this->buildWarningMessage($student_data, $warning_data);

        $recipient = [
            'email' => $student_data['email'],
            'phone' => $student_data['phone'] ?? null
        ];

        return $this->sendMultiChannel($recipient, $subject, $message, $channels);
    }

    /**
     * Build message untuk warning
     */
    private function buildWarningMessage($student, $warning)
    {
        $text = "Assalamu'alaikum,\n\n";
        $text .= "Sistem kami mendeteksi hal berikut untuk siswa " . $student['name'] . ":\n\n";
        $text .= "📌 Judul: " . $warning['title'] . "\n";
        $text .= "📝 Deskripsi: " . $warning['description'] . "\n";
        $text .= "⚠️ Tingkat: " . strtoupper($warning['severity']) . "\n\n";
        $text .= "Mohon segera mengambil tindakan yang diperlukan.\n\n";
        $text .= "Salam,\nSistem EkskulOnline";

        return $text;
    }
}
