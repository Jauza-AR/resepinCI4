<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Reseplangkah extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_langkah' => 1,
                'id_resep' => 1,
                'urutan' => 1,
                'isi_langkah' => 'Cuci beras hingga bersih.',
            ],
            [
                'id_langkah' => 2,
                'id_resep' => 1,
                'urutan' => 2,
                'isi_langkah' => 'Masak beras dengan air hingga matang.',
            ],
            [
                'id_langkah' => 3,
                'id_resep' => 2,
                'urutan' => 1,
                'isi_langkah' => 'Potong daging ayam menjadi bagian kecil.',
            ],
            [
                'id_langkah' => 4,
                'id_resep' => 2,
                'urutan' => 2,
                'isi_langkah' => 'Masak daging ayam dengan bumbu kari hingga matang.',
            ],
            [
                'id_langkah' => 5,
                'id_resep' => 3,
                'urutan' => 1,
                'isi_langkah' => 'Bersihkan ikan salmon.',
            ],
            [
                'id_langkah' => 6,
                'id_resep' => 3,
                'urutan' => 2,
                'isi_langkah' => 'Peras lemon dan campurkan dengan ikan salmon.',
            ],
        ];
        $this->db->table('langkah_resep')->insertBatch($data);
    }
}
