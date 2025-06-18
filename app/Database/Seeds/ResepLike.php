<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResepLike extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_pengguna' => 1,
                'id_resep' => 1,
                'status' => true,
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 1,
                'status' => true,
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 2,
                'status' => false,
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 3,
                'status' => false,
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 4,
                'status' => false,
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 5,
                'status' => false,
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 2,
                'status' => true,
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 3,
                'status' => true,
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 4,
                'status' => false,
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 5,
                'status' => false,
            ],
        ];

        $this->db->table('resep_like')->insertBatch($data);
    }
}
