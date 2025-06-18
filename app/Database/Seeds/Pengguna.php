<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pengguna extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_pengguna' => 1,
                'nama_pengguna' => 'Andi Saputra',
                'email' => 'andi.saputra@example.com',
                'password' => 'password1',
                'bio' => 'Pecinta masakan nusantara dan suka mencoba resep baru.',
                'foto_profil' => 'https://picsum.photos/234?random=1',
            ],
            [
                'id_pengguna' => 2,
                'nama_pengguna' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => 'password2',
                'bio' => 'Hobi memasak dan berbagi resep sehat.',
                'foto_profil' => 'https://picsum.photos/234?random=2',
            ],
            [
                'id_pengguna' => 3,
                'nama_pengguna' => 'Citra Dewi',
                'email' => 'citra.dewi@example.com',
                'password' => 'password3',
                'bio' => 'Food blogger dan penikmat kuliner tradisional.',
                'foto_profil' => 'https://picsum.photos/234?random=3',
            ],
            [
                'id_pengguna' => 4,
                'nama_pengguna' => 'Dewi Lestari',
                'email' => 'dewi.lestari@example.com',
                'password' => 'password4',
                'bio' => 'Suka memasak makanan manis dan dessert.',
                'foto_profil' => 'https://picsum.photos/234?random=4',
            ],
            [
                'id_pengguna' => 5,
                'nama_pengguna' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@example.com',
                'password' => 'password5',
                'bio' => 'Chef rumahan yang suka bereksperimen dengan bumbu.',
                'foto_profil' => 'https://picsum.photos/234?random=5',
            ],
            [
                'id_pengguna' => 6,
                'nama_pengguna' => 'Fitriani',
                'email' => 'fitriani@example.com',
                'password' => 'password6',
                'bio' => 'Penyuka masakan pedas dan seafood.',
                'foto_profil' => 'https://picsum.photos/234?random=6',
            ],
            [
                'id_pengguna' => 7,
                'nama_pengguna' => 'Gilang Ramadhan',
                'email' => 'gilang.ramadhan@example.com',
                'password' => 'password7',
                'bio' => 'Suka berbagi resep masakan keluarga.',
                'foto_profil' => 'https://picsum.photos/234?random=7',
            ],
            [
                'id_pengguna' => 8,
                'nama_pengguna' => 'Hana Putri',
                'email' => 'hana.putri@example.com',
                'password' => 'password8',
                'bio' => 'Food enthusiast dan penikmat kopi.',
                'foto_profil' => 'https://picsum.photos/234?random=8',
            ],
            [
                'id_pengguna' => 9,
                'nama_pengguna' => 'Irwan Maulana',
                'email' => 'irwan.maulana@example.com',
                'password' => 'password9',
                'bio' => 'Suka memasak makanan khas daerah.',
                'foto_profil' => 'https://picsum.photos/234?random=9',
            ],
            [
                'id_pengguna' => 10,
                'nama_pengguna' => 'Jihan Safitri',
                'email' => 'jihan.safitri@example.com',
                'password' => 'password10',
                'bio' => 'Pencinta kuliner dan suka traveling kuliner.',
                'foto_profil' => 'https://picsum.photos/234?random=10',
            ],
        ];

        $this->db->table('pengguna')->insertBatch($data);
    }
}
