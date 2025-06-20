<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepModel extends Model
{
    protected $table            = 'resep';
    protected $primaryKey       = 'id_resep';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Resep';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_resep',
        'id_pengguna',
        'nama_resep',
        'gambar',
        'kategori',
        'deskripsi',
        'tanggal_unggah',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_resep' => 'required|min_length[5]|max_length[20]',
        'gambar' => 'required',
        'kategori' => 'required',
        'deskripsi' => 'required|min_length[5]|max_length[400]',
        'tanggal_unggah' => 'required|valid_date',
    ];
    protected $validationMessages   = [
        'nama_resep' => [
            'required' => 'Silakan masukan nama resep',
            'min_length' => 'Nama resep minimal 5 karakter',
            'max_length' => 'Nama resep maksimal 20 karakter',
        ],
        'gambar' => [
            'required' => 'Silakan upload gambar'
        ],
        'kategori' => [
            'required' => 'Silakan masukan kategori'
        ],
        'deskripsi' => [
            'required' => 'Silakan masukan deskripsi',
            'min_length' => 'Deskripsi minimal 5 karakter',
            'max_length' => 'Deskripsi maksimal 400 karakter',
        ],
        'tanggal_unggah' => [
            'required' => 'Silakan masukan tanggal unggah',
            'valid_date' => 'Format tanggal Tahun-Bulan-Tanggal'
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
