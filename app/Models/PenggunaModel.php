<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id_pengguna';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Pengguna';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengguna',
        'nama_pengguna',
        'email',
        'password',
        'bio',
        'foto_profil',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_pengguna'   => 'required|min_length[3]|max_length[20]',
        'email' => 'required|valid_email|is_unique[pengguna.email]',
        'password'        => 'required|min_length[8]',
        'bio'             => 'permit_empty|max_length[255]',
        'foto_profil'     => 'permit_empty|valid_url',
        
    ];
    protected $validationMessages   = [
        'nama_pengguna' => [
            'required'    => 'Nama pengguna harus diisi.',
            'min_length'  => 'Nama pengguna minimal 3 karakter.',
            'max_length'  => 'Nama pengguna maksimal 20 karakter.',
        ],
        'email' => [
            'required'    => 'Email harus diisi.',
            'valid_email' => 'Email tidak valid.',
            'is_unique'   => 'Email sudah terdaftar.',
        ],
        'password' => [
            'required'    => 'Password harus diisi.',
            'min_length'  => 'Password minimal 8 karakter.',
        ],
        'bio' => [
            'max_length'  => 'Bio maksimal 255 karakter.',
        ],
        'foto_profil' => [
            'valid_url'   => 'Foto profil harus berupa URL yang valid.',
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
