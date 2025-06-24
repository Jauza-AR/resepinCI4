<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenggunaFavorit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengguna_favorit' => [
                'type' => 'INT',
                'auto_increment' => true,
                
            ],
            'id_pengguna' => [
                'type' => 'INT',
                
            ],
            '   ' => [
                'type' => 'INT',
                
            ],
        ]);

        $this->forge->addKey('id_pengguna_favorit', true);
        $this->forge->createTable('pengguna_favorit');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna');
        $this->forge->addForeignKey('tambah_pengguna_favorit', 'pengguna', 'id_pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna_favorit');
    }
}
