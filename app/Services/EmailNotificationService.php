<?php
namespace App\Services;

class EmailNotificationService
{
    /**
     * Kirim email menggunakan Email Library CodeIgniter
     */
    public function send($to, $subject, $message, $html = true)
    {
        try {
            $email = \Config\Services::email();
            
            $email->setFrom('noreply@ekskulonline.com', 'EkskulOnline System');
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);

            // Jika $html true, render sebagai HTML
            if($html) {
                $email->setAltMessage(strip_tags($message));
            }

            if($email->send()) {
                log_message('info', "Email sent successfully to: $to");
                return ['status' => true, 'message' => 'Email berhasil dikirim'];
            } else {
                $debug = $email->printDebugger(['headers']);
                log_message('error', "Email failed for $to: " . $debug);
                return ['status' => false, 'message' => 'Gagal mengirim email. SMTP mungkin tidak dikonfigurasi.'];
            }
        } catch(\Throwable $e) {
            log_message('error', 'Email error: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Template HTML untuk early warning
     */
    public function getEarlyWarningTemplate($student_name, $warning_title, $warning_description, $severity)
    {
        $severityColor = $severity === 'high' ? '#dc2626' : ($severity === 'medium' ? '#f59e0b' : '#22c55e');
        
        $html = "
        <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #4f46e5; color: white; padding: 20px; border-radius: 5px; text-align: center; }
                    .content { background-color: #f9fafb; padding: 20px; margin: 20px 0; border-radius: 5px; }
                    .warning-box { background-color: $severityColor; color: white; padding: 15px; border-radius: 5px; margin: 20px 0; }
                    .footer { text-align: center; color: #999; font-size: 12px; margin-top: 30px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>⚠️ Peringatan Dini Sistem</h1>
                    </div>
                    
                    <div class='content'>
                        <p>Halo,</p>
                        <p>Sistem kami telah mendeteksi kondisi yang perlu perhatian untuk siswa <strong>$student_name</strong>.</p>
                        
                        <div class='warning-box'>
                            <h3>$warning_title</h3>
                            <p>$warning_description</p>
                            <p><strong>Tingkat Keberatan: " . strtoupper($severity) . "</strong></p>
                        </div>
                        
                        <p>Mohon segera mengambil tindakan yang diperlukan untuk membantu siswa.</p>
                        <p>Jika Anda memiliki pertanyaan, silakan hubungi administrator sistem.</p>
                    </div>
                    
                    <div class='footer'>
                        <p>&copy; 2025 EkskulOnline. Sistem Informasi Pendaftaran Ekskul Online</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        return $html;
    }
}
