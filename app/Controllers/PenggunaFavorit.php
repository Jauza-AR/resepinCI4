<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class PenggunaFavorit extends ResourceController
{
    protected $modelName = 'App\Models\PenggunaFavoritModel';
    protected $format    = 'json';

    /**
     * Tampilkan semua favorit milik pengguna tertentu
     * GET /penggunafavorit/{id_pengguna}
     */
    public function index($id_pengguna = null)
    {
        if (!$id_pengguna) {
            return $this->fail('ID pengguna wajib diisi');
        }
        $favorit = $this->model->where('id_pengguna', $id_pengguna)->findAll();
        return $this->respond($favorit);
    }

    /**
     * Tambahkan pengguna favorit
     * POST /penggunafavorit
     * Body: id_pengguna, tambah_pengguna_favorit
     */
    public function create()
    {
        $data = [
            'id_pengguna' => $this->request->getPost('id_pengguna'),
            'tambah_pengguna_favorit' => $this->request->getPost('tambah_pengguna_favorit')
        ];

        if (!$data['id_pengguna'] || !$data['tambah_pengguna_favorit']) {
            return $this->fail('Parameter tidak lengkap');
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Hapus pengguna favorit berdasarkan id_pengguna dan tambah_pengguna_favorit
     * DELETE /penggunafavorit/{id_pengguna}/{tambah_pengguna_favorit}
     */
    public function delete($id_pengguna = null, $tambah_pengguna_favorit = null)
    {
        if (!$id_pengguna || !$tambah_pengguna_favorit) {
            return $this->fail('Parameter tidak lengkap');
        }

        $deleted = $this->model
            ->where('id_pengguna', $id_pengguna)
            ->where('tambah_pengguna_favorit', $tambah_pengguna_favorit)
            ->delete();

        if ($deleted) {
            return $this->respondDeleted([
                'id_pengguna' => $id_pengguna,
                'tambah_pengguna_favorit' => $tambah_pengguna_favorit
            ]);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }
}