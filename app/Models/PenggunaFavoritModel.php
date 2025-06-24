<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaFavoritModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengguna_favorit';
    protected $primaryKey       = 'id_pengguna_favorit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengguna_favorit',
        'id_pengguna',
        'tambah_pengguna_favorit',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_pengguna' => 'required|is_natural_no_zero',
        'tambah_pengguna_favorit' => 'required|is_natural_no_zero',
    ];
    protected $validationMessages   = [

        'id_pengguna' => [
            'required' => 'ID pengguna harus diisi.',
            'is_natural_no_zero' => 'ID pengguna harus berupa angka positif.',
            
        ],
        'tambah_pengguna_favorit' => [
            'required' => 'ID pengguna yang ditambahkan sebagai favorit harus diisi.',
            'is_natural_no_zero' => 'ID pengguna yang ditambahkan sebagai favorit harus berupa angka positif.',
            // 'is_unique' => 'Pengguna favorit ini sudah ada.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
