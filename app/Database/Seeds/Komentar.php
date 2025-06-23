<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Komentar extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_pengguna' => 1,
                'id_resep' => 1,
                'isi_komentar' => 'Ini adalah komentar pertama',
                'waktu_komentar' => '2025-06-19 15:45:00',
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 1,
                'isi_komentar' => 'Komentar kedua pada resep 1',
                'waktu_komentar' => '2025-06-19 15:46:00',
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 2,
                'isi_komentar' => 'Komentar pada resep 2',
                'waktu_komentar' => '2025-06-19 15:47:00',
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 2,
                'isi_komentar' => 'Komentar kedua pada resep 2',
                'waktu_komentar' => '2025-06-19 15:48:00',
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 3,
                'isi_komentar' => 'Komentar pada resep 3',
                'waktu_komentar' => '2025-06-19 15:49:00',
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 3,
                'isi_komentar' => 'Komentar kedua pada resep 3',
                'waktu_komentar' => '2025-06-19 15:50:00',
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 4,
                'isi_komentar' => 'Komentar pada resep 4',
                'waktu_komentar' => '2025-06-19 15:51:00',
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 4,
                'isi_komentar' => 'Komentar kedua pada resep 4',
                'waktu_komentar' => '2025-06-19 15:52:00',
            ],
            [
                'id_pengguna' => 1,
                'id_resep' => 5,
                'isi_komentar' => 'Komentar pada resep 5',
                'waktu_komentar' => '2025-06-19 15:53:00',
            ],
            [
                'id_pengguna' => 2,
                'id_resep' => 5,
                'isi_komentar' => 'Komentar kedua pada resep 5',
                'waktu_komentar' => '2025-06-19 15:54:00',
            ],
        ];

        $this->db->table('komentar')->insertBatch($data);
    }
}
