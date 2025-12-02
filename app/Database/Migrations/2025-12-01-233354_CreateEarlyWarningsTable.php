<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEarlyWarningsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'student_id' => ['type' => 'INT', 'null' => false],
            'type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'description' => ['type' => 'TEXT', 'null' => true],
            'severity' => ['type' => 'ENUM', 'constraint' => ['low','medium','high'], 'default' => 'low'],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','resolved'], 'default' => 'active'],
            'notified' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('student_id');
        $this->forge->createTable('early_warnings');
    }

    public function down()
    {
        $this->forge->dropTable('early_warnings');
    }
}
