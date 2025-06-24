<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanResepModel extends Model
{
    protected $table            = 'bahan_resep';
    protected $primaryKey       = 'id_bahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\BahanResep';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        // 'id_bahan',
        'id_resep',
        'nama_bahan',
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
        // 'id_bahan' => 'required|integer',
        'id_resep' => 'required|integer',
        'nama_bahan' => 'required|string|max_length[100]',
    ];
    protected $validationMessages   = [
        // 'id_bahan' => [
        //     'required' => 'ID bahan harus terisi.',
        //     'integer'  => 'ID bahan harus berupa angka.',
        // ],
        'id_resep' => [
            'required' => 'ID resep harus terisi.',
            'integer'  => 'ID resep harus berupa angka.',
        ],
        'nama_bahan' => [
            'required' => 'Nama bahan harus diisi.',
            'string'   => 'Nama bahan harus berupa string.',
            'max_length' => 'Nama bahan maksimal 100 karakter.',
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
