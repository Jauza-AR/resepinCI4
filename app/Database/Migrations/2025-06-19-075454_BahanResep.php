<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BahanResep extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bahan' => [
                'type' => 'INT',
                'auto_increment' => true
            ],

            'id_resep' => [
                'type' => 'INT',
            ],

            'nama_bahan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ]
        ]);

        $this->forge->addKey('id_bahan', true);
        $this->forge->addForeignKey('id_resep', 'resep', 'id_resep', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bahan_resep');
    }

    public function down()
    {
        $this->forge->dropTable('bahan_resep');
    }
}
