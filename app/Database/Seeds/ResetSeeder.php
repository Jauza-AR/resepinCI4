<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetSeeder extends Seeder
{
    public function run()
    {
        // $this->db->table('resep_like')->truncate();
        // $this->db->table('resep_favorit')->truncate();
        $this->db->table('pengguna')->truncate();
        $this->db->table('resep')->truncate();
        // $this->db->table('PenggunaFavorit')->truncate();
    }
}
