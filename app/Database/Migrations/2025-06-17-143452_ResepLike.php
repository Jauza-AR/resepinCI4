<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResepLike extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_like' => [
                'type' => 'INT',
                // 'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_pengguna' => [
                'type' => 'INT',
                // 'constraint' => 11,
                'null' => false,
            ],
            'id_resep' => [
                'type' => 'INT',
                // 'constraint' => 11,
                'null' => false,
            ],
            'status' => [
                'type' => 'BOOLEAN',
                // 'constraint' => 1,
                'null' => false,
            ],
        ]);

        
                $this->forge->addKey('id_like', true);
                $this->forge->addForeignKey('id_resep', 'resep', 'id_resep');
                $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna'); // Tambahkan baris ini
                $this->forge->createTable('resep_like');
        
    }

    public function down()
    {
        $this->forge->dropTable('resep_like');
    }
}