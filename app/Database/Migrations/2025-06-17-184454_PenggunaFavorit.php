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
                
            ],
            'id_pengguna' => [
                'type' => 'INT',
                
            ],
            'tambah_pengguna_favorit' => [
                'type' => 'INT',
                
            ],
        ]);

        $this->forge->addKey('id_pengguna_favorit', true);
        $this->forge->createTable('pengguna_favorit');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna_favorit');
    }
}
