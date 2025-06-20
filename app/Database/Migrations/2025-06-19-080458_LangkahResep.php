<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LangkahResep extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_langkah' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],

            'id_resep' => [
                'type' => 'INT',
            ],

            'urutan' => [
                'type' => 'INT',
            ],
            
            'isi_langkah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);

        $this->forge->addKey('id_langkah', true);
        $this->forge->addForeignKey('id_resep', 'resep', 'id_resep', 'CASCADE', 'CASCADE');
        $this->forge->createTable('langkah_resep');
    }

    public function down()
    {
        $this->forge->dropTable('langkah_resep');
    }
}
