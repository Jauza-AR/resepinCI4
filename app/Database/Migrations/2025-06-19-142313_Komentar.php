<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Komentar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_komentar' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_pengguna' => [
                'type' => 'INT',
                'null' => false,
            ],
            'id_resep' => [
                'type' => 'INT',
                'null' => false,
            ],
            'isi_komentar' => [
                'type' => 'TEXT',
                'null' => false,
            ],
           'waktu_komentar' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id_komentar', true);
        $this->forge->addForeignKey('id_resep', 'resep', 'id_resep');
        $this->forge->addForeignKey('id_pengguna', 'pengguna', 'id_pengguna');
        $this->forge->createTable('komentar');
    }

    public function down()
    {
        $this->forge->dropTable('komentar');
    }
}
