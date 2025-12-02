<?php
namespace App\Services;

class WhatsAppNotificationService
{
    /**
     * Kirim pesan WhatsApp menggunakan API WhatsApp (Twilio atau provider lain)
     * 
     * Konfigurasi di .env:
     * WHATSAPP_PROVIDER=twilio
     * WHATSAPP_ACCOUNT_SID=xxxxx
     * WHATSAPP_AUTH_TOKEN=xxxxx
     * WHATSAPP_PHONE_NUMBER=+1234567890
     * 
     * Atau menggunakan provider lain seperti:
     * - Green API
     * - WhatsApp Business API
     * - Fonnte
     */
    
    public function send($phone, $message)
    {
        // Log attempt
        log_message('info', "WhatsApp send attempt to: $phone");
        
        $provider = env('WHATSAPP_PROVIDER', 'twilio');

        switch($provider) {
            case 'twilio':
                return $this->sendViatwilio($phone, $message);
            case 'green_api':
                return $this->sendViaGreenAPI($phone, $message);
            case 'fonnte':
                return $this->sendViaFonnte($phone, $message);
            default:
                log_message('error', "WhatsApp provider not configured: $provider");
                return [
                    'status' => false, 
                    'message' => 'WhatsApp provider tidak dikonfigurasi di .env. Baca SETUP_NOTIFIKASI.md'
                ];
        }
    }

    /**
     * Kirim via Twilio WhatsApp
     */
    private function sendViatwilio($phone, $message)
    {
        try {
            $account_sid = env('WHATSAPP_ACCOUNT_SID');
            $auth_token = env('WHATSAPP_AUTH_TOKEN');
            $from_number = env('WHATSAPP_PHONE_NUMBER');

            if (!$account_sid || !$auth_token || !$from_number) {
                log_message('error', 'Twilio credentials not configured in .env');
                throw new \Exception('Twilio credentials tidak dikonfigurasi');
            }

            $client = new \Twilio\Rest\Client($account_sid, $auth_token);
            
            $msg = $client->messages->create(
                "whatsapp:$phone",
                [
                    "from" => "whatsapp:$from_number",
                    "body" => $message
                ]
            );

            log_message('info', "Twilio message sent successfully to $phone");
            return ['status' => true, 'message' => 'Pesan WhatsApp berhasil dikirim', 'sid' => $msg->sid];
        } catch(\Throwable $e) {
            log_message('error', "Twilio error: " . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Kirim via Green API
     */
    private function sendViaGreenAPI($phone, $message)
    {
        try {
            $instance_id = env('WHATSAPP_INSTANCE_ID');
            $instance_key = env('WHATSAPP_INSTANCE_KEY');
            
            if (!$instance_id || !$instance_key) {
                log_message('error', 'Green API credentials not configured in .env');
                throw new \Exception('Green API credentials tidak dikonfigurasi');
            }

            $api_url = "https://api.green-api.com/waInstance{$instance_id}";
            $client = \Config\Services::curlRequest();
            
            $response = $client->post("$api_url/SendMessage/$instance_key", [
                'json' => [
                    'chatId' => $phone . '@c.us',
                    'message' => $message
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            
            if($result['idMessage'] ?? false) {
                log_message('info', "Green API message sent successfully to $phone");
                return ['status' => true, 'message' => 'Pesan WhatsApp berhasil dikirim'];
            } else {
                log_message('error', "Green API error: " . json_encode($result));
                return ['status' => false, 'message' => 'Gagal mengirim pesan'];
            }
        } catch(\Throwable $e) {
            log_message('error', "Green API error: " . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Kirim via Fonnte
     */
    private function sendViaFonnte($phone, $message)
    {
        try {
            $token = env('WHATSAPP_FONNTE_TOKEN');
            
            if (!$token) {
                log_message('error', 'Fonnte credentials not configured in .env');
                throw new \Exception('Fonnte token tidak dikonfigurasi');
            }

            $api_url = "https://api.fonnte.com/send";
            $client = \Config\Services::curlRequest();
            
            $response = $client->post($api_url, [
                'headers' => [
                    'Authorization' => $token
                ],
                'json' => [
                    'target' => $phone,
                    'message' => $message,
                    'countryCode' => '62'
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            
            if($result['status'] ?? false) {
                log_message('info', "Fonnte message sent successfully to $phone");
                return ['status' => true, 'message' => 'Pesan WhatsApp berhasil dikirim'];
            } else {
                log_message('error', "Fonnte error: " . json_encode($result));
                return ['status' => false, 'message' => $result['reason'] ?? 'Gagal mengirim pesan'];
            }
        } catch(\Throwable $e) {
            log_message('error', "Fonnte error: " . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Kirim WhatsApp template/bulk message
     */
    public function sendBulk($recipients, $message)
    {
        $results = [];

        foreach($recipients as $phone) {
            $results[$phone] = $this->send($phone, $message);
        }

        return $results;
    }

    /**
     * Format nomor telepon ke format E.164
     */
    public function formatPhone($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika dimulai dengan 0, ganti dengan 62
        if(substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum dimulai dengan 62, tambahkan
        if(substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return '+' . $phone;
    }
}
