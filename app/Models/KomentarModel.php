<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table            = 'komentar';
    protected $primaryKey       = 'id_komentar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Komentar';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengguna',
        'id_resep',
        'isi_komentar',
        
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
        'id_pengguna'     => 'required|integer',
        'id_resep'        => 'required|integer',
        'isi_komentar'    => 'required|string|max_length[500]',
        
    ];
    protected $validationMessages   = [
        'id_pengguna' => [
            'required' => 'ID Pengguna harus diisi.',
            'integer'  => 'ID Pengguna harus berupa angka.',
        ],
        'id_resep' => [
            'required' => 'ID Resep harus diisi.',
            'integer'  => 'ID Resep harus berupa angka.',
        ],
        'isi_komentar' => [
            'required'    => 'Isi komentar harus diisi.',
            'string'      => 'Isi komentar harus berupa teks.',
            'max_length'  => 'Isi komentar tidak boleh lebih dari 500 karakter.',
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
