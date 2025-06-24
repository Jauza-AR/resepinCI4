<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepLikeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'resep_like';
    protected $primaryKey       = 'id_like';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\ResepLike';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengguna',
        'id_resep',
        'status',
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
        'id_pengguna' => 'required|integer',
        'id_resep' => 'required|integer',
        'status' => 'required',
    ];
    protected $validationMessages   = [
        'id_pengguna' => [
            'required' => 'ID pengguna harus diisi.',
            'integer'  => 'ID pengguna harus berupa angka.',
        ],
        'id_resep' => [
            'required' => 'ID resep harus diisi.',
            'integer'  => 'ID resep harus berupa angka.',
        ],
        'status' => [
            'required' => 'Status harus diisi.',
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
