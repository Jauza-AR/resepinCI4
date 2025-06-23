<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResepFavorit extends Seeder
{
    public function run()
    {
        // // Cara 1
        // // 1. Ambil ID pengguna
        // $pengguna = $this->db->table('pengguna')->where('email', 'andi.saputra@example.com')->get()->getRow();
        // $penggunaId = $pengguna->id_pengguna;

        // // 2. Ambil ID resep
        // $resep = $this->db->table('resep')->where('nama_resep', 'Pisang Goreng Crispy')->get()->getRow();
        // $resepId = $resep->id_resep;

        // // 3. Masukkan ke tabel pengguna_favorit
        // $data = [
        //     'id_pengguna' => 1,
        //     'id_resep'    => 4
        // ];

        // $this->db->table('resep_favorit')->insert($data);

        // Cara 2
        $data = [
            [
                'id_pengguna' => 1,
                'id_resep'    => 3
            ],
            [
                'id_pengguna' => 2,
                'id_resep'    => 7
            ],
            [
                'id_pengguna' => 3,
                'id_resep'    => 5
            ],
            [
                'id_pengguna' => 4,
                'id_resep'    => 2
            ],
            [
                'id_pengguna' => 5,
                'id_resep'    => 9
            ],
            [
                'id_pengguna' => 6,
                'id_resep'    => 1
            ],
            [
                'id_pengguna' => 7,
                'id_resep'    => 10
            ],
            [
                'id_pengguna' => 8,
                'id_resep'    => 4
            ],
            [
                'id_pengguna' => 9,
                'id_resep'    => 8
            ],
            [
                'id_pengguna' => 10,
                'id_resep'    => 6
            ],
        ];


        $this->db->table('resep_favorit')->insertBatch($data);
    }
}
