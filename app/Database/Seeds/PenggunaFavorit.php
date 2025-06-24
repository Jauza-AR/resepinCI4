<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaFavorit extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_pengguna' => 1,
                'tambah_pengguna_favorit' => 2,
            ],
            [
                'id_pengguna' => 1,
                'tambah_pengguna_favorit' => 3,
            ],
            [
                'id_pengguna' => 1,
                'tambah_pengguna_favorit' => 1,
            ],
            [
                'id_pengguna' => 4,
                'tambah_pengguna_favorit' => 5,
            ],
            [
                'id_pengguna' => 5,
                'tambah_pengguna_favorit' => 4,
            ],
            [
                'id_pengguna' => 6,
                'tambah_pengguna_favorit' => 7,
            ],
            [
                'id_pengguna' => 7,
                'tambah_pengguna_favorit' => 6,
            ],
            [
                'id_pengguna' => 8,
                'tambah_pengguna_favorit' => 9,
            ],
            [
                'id_pengguna' => 9,
                'tambah_pengguna_favorit' => 8,
            ],
        ];

        // Using Query Builder
        $this->db->table('pengguna_favorit')->insertBatch($data);
    }
}
