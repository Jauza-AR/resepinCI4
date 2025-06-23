<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepFavoritModel extends Model
{
    protected $table            = 'resep_favorit';
    protected $primaryKey       = 'id_resep_favorit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\ResepFavorit';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengguna',
        'id_resep',
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
        'id_pengguna' => 'required|integer|is_not_unique[pengguna.id_pengguna]',
        'id_resep'    => 'required|integer|is_not_unique[resep.id_resep]',
    ];
    protected $validationMessages   = [
        'id_pengguna' => [
        'required' => 'Pengguna harus diisi.',
        'integer' => 'ID Pengguna harus berupa angka.',
        'is_not_unique' => 'Pengguna tidak ditemukan.'
        ],
        'id_resep' => [
            'required' => 'Resep harus diisi.',
            'integer' => 'ID Resep harus berupa angka.',
            'is_not_unique' => 'Resep tidak ditemukan.'
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
