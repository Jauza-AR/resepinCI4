<?php

namespace App\Models;

use CodeIgniter\Model;

class LangkahResepModel extends Model
{
    protected $table            = 'langkah_resep';
    protected $primaryKey       = 'id_langkah';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\LangkahResep';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        // 'id_langkah',
        'id_resep',
        'urutan',
        'isi_langkah',
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
        // 'id_langkah' => 'required|integer',
        'id_resep' => 'required|integer',
        'urutan' => 'required|integer',  //Tambah Integer 
        'isi_langkah' => 'required|string|max_length[255]',
    ];
    protected $validationMessages   = [
        // 'id_langkah' => [
        //     'required' => 'ID bahan harus terisi.',
        //     'integer'  => 'ID bahan harus berupa angka.',
        // ],
        'id_resep' => [
            'required' => 'ID resep harus terisi.',
            'integer'  => 'ID resep harus berupa angka.',
        ],
        'urutan' => [
            'required' => 'Urutan harus diisi.',
            'integer' => 'Urutan Harus Berupa Angka'  //Tambahan
        ],
        'isi_langkah' => [
            'required' => 'Isi langkah harus diisi.',
            'string'   => 'isi langkah harus berupa teks', //tambah ini
            'max_length' => 'Masukkan Langkah Langkah maksimal 255 karakter.',
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
