<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWhatsappEmailToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true, 'comment' => 'Nomor WhatsApp untuk notifikasi'],
            'notification_email' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true, 'comment' => 'Email untuk notifikasi (opsional, default ke email akun)'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['phone_number', 'notification_email']);
    }
}
