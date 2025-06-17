<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResepFavorit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_resep_favorit'=> [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_pengguna'=> [
                'type' => 'INT',
            ],
            'id_resep'=> [
                'type' => 'INT',
            ]
        ]);

        $this->forge->addKey('id_resep_favorit', true);
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_resep', 'resep', 'id_resep', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resep_favorit');
    }

    public function down()
    {
        $this->forge->dropTable('resep_favorit');
    }
}
