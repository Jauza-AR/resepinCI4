<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('Pengguna');
        $this->call('Resep');
        $this->call('ResepLike');
        $this->call('ResepFavorit');
        $this->call('Resepbahan');
        $this->call('Reseplangkah');
        $this->call('Komentar');
    }
}
