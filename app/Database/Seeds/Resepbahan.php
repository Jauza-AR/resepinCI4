<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Resepbahan extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_bahan' => 1,
                'id_resep' => 1,
                'nama_bahan' => 'Beras',
            ],
            [
                'id_bahan' => 2,
                'id_resep' => 1,
                'nama_bahan' => 'Air',
            ],
            [
                'id_bahan' => 3,
                'id_resep' => 2,
                'nama_bahan' => 'Daging Ayam',
            ],
            [
                'id_bahan' => 4,
                'id_resep' => 2,
                'nama_bahan' => 'Bumbu Kari',
            ],
            [
                'id_bahan' => 5,
                'id_resep' => 3,
                'nama_bahan' => 'Ikan Salmon',
            ],
            [
                'id_bahan' => 6,
                'id_resep' => 3,
                'nama_bahan' => 'Lemon',
            ],
        ];
        $this->db->table('bahan_resep')->insertBatch($data);
    }
}
