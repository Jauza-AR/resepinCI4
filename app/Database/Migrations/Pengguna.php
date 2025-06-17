<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengguna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengguna' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama_pengguna' => [
                'type' => 'varchar',
                'constraint' => '20',
                'null' => false,
                'unique' => true,
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => false,
                'unique' => true,,
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '225',
                'null' => false,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto_profil' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);

        
        



        $this->forge->addKey('id_pengguna', true);
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}
