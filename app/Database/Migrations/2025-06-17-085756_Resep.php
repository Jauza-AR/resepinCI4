<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Resep extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_resep' => [
                'type'           => 'INT',
                'auto_increment' => true
            ],
            'id_pengguna' => [
                'type'       => 'INT',
                'null'       => false
            ],
            'nama_resep' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tanggal_unggah' => [
                'type'    => 'DATE',
                'null'    => false,                
            ],
        ]);
        $this->forge->addKey('id_resep', true);
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna');
        $this->forge->createTable('resep');
    }

    public function down()
    {
        $this->forge->dropTable('resep');
    }
}
