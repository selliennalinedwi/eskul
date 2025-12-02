<?php
namespace App\Models;
use CodeIgniter\Model;

class AIModel extends Model
{
    // Chatbot FAQ sederhana
    public function chatResponse($message)
    {
        $msg = strtolower($message);

        if(strpos($msg,'robotik') !== false){
            return 'Ekskul Robotik: belajar programming & robotik.';
        } elseif(strpos($msg,'futsal') !== false){
            return 'Ekskul Futsal: latihan & kompetisi olahraga.';
        } elseif(strpos($msg,'daftar') !== false){
            return 'Silakan login dan pilih ekskul untuk mendaftar.';
        } else {
            return 'Maaf, saya tidak mengerti. Coba pertanyaan lain.';
        }
    }

    // Virtual Assistant AI canggih (menggunakan OpenAI)
    public function virtualAssistant($message)
    {
        $apiKey = getenv('OPENAI_API_KEY');
        $postData = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role"=>"system","content"=>"Kamu adalah asisten pendaftaran ekskul online yang ramah, cerdas, dan membantu. Berikan panduan lengkap, rekomendasi ekskul, dan validasi data."],
                ["role"=>"user","content"=>$message]
            ],
            "temperature"=>0.7
        ];

        $ch = curl_init("https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response,true);
        return $data['choices'][0]['message']['content'] ?? 'Maaf, saya tidak bisa menjawab sekarang.';
    }
}
