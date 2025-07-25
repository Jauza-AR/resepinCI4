<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ResepFavorit extends ResourceController
{
    protected $modelName = 'App\Models\ResepFavoritModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        } else {
            return $this->respond($this->model->find($id));
        }
    }


    public function new()
    {
        //
    }


    public function create()
    {
        $data = $this->request->getPost();
        $resepFavorit = new \App\Entities\ResepFavorit();
        $resepFavorit->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resepFavorit)) {
            return $this->respondCreated($data, "Resep Favorit Berhasil Dibuat");
        }
    }


    public function edit($id = null)
    {
        //
    }


    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_resep_favorit'] = $id;
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        $resepFavorit = new \App\Entities\ResepFavorit();
        $resepFavorit->fill($data);
        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resepFavorit)) {
            return $this->respondUpdated($data, "Resep Favorit Berhasil Diupdate");
        }
    }


    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        if ($this->model->delete($id)) {
            return $this->respondDeleted("Data dengan id " . $id . " berhasil dihapus");
        }
    }

    public function addToFavorites()
    {
        $id_pengguna = $this->request->getPost('id_pengguna');
        $id_resep = $this->request->getPost('id_resep');

        if (!$id_pengguna || !$id_resep) {
            return $this->failValidationErrors('ID Pengguna dan ID Resep harus diisi.');
        }

        $existing = $this->model->table('resep_favorit')
            ->where(['id_pengguna' => $id_pengguna, 'id_resep' => $id_resep])
            ->get()->getRow();

        if ($existing) {
            return $this->respond(['message' => 'Resep sudah ada di favorit']);
        }

        $data = [
            'id_pengguna' => $id_pengguna,
            'id_resep' => $id_resep
        ];

        $this->model->table('resep_favorit')->insert($data);

        return $this->respondCreated(['message' => 'Resep berhasil ditambahkan ke favorit']);
    }

    // public function removeFromFavorites($idPengguna, $idResep)
    // {
    //     $data = $this->model
    //         ->where('id_pengguna', $idPengguna)
    //         ->where('id_resep', $idResep)
    //         ->first();

    //     if (!$data) {
    //         return $this->failNotFound("Resep favorit tidak ditemukan");
    //     }

    //     if ($this->model->delete($data['id'])) {
    //         return $this->respondDeleted("Resep favorit berhasil dihapus");
    //     } else {
    //         return $this->failServerError("Gagal menghapus resep favorit");
    //     }
    // }


    public function removeFromFavorites()
    {
        $id_pengguna = $this->request->getPost('id_pengguna');
        $id_resep = $this->request->getPost('id_resep');

        if (!$id_pengguna || !$id_resep) {
            return $this->failValidationErrors('ID Pengguna dan ID Resep diperlukan.');
        }

        // Cari entri berdasarkan kombinasi id_pengguna dan id_resep
        $favorit = $this->model->table('resep_favorit')
            ->where(['id_pengguna' => $id_pengguna, 'id_resep' => $id_resep])
            ->get()->getRow();

        if (!$favorit) {
            return $this->respond(['message' => 'Resep tidak ada di favorit']);
        }

        // Hapus entri
        $this->model->table('resep_favorit')
            ->where(['id_pengguna' => $id_pengguna, 'id_resep' => $id_resep])
            ->delete();

        return $this->respond(['message' => 'Berhasil dihapus dari favorit']);
    }

    public function getFavoritesByUser($id_pengguna = null)
    {
        if (!$id_pengguna) {
            return $this->failValidationErrors('ID Pengguna harus diisi.');
        }

        $builder = $this->model->table('resep_favorit');
        $builder->select('resep.id_resep, resep.nama_resep, resep.gambar, resep.kategori, resep.deskripsi, resep.tanggal_unggah');
        $builder->join('resep', 'resep.id_resep = resep_favorit.id_resep');
        $builder->where('resep_favorit.id_pengguna', $id_pengguna);
        $result = $builder->get()->getResult();

        return $this->respond($result);
    }

    // Memeriksa apakah resep ada di favorit
    public function check()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id_pengguna']) || empty($data['id_resep'])) {
            return $this->respond([
                'status' => 400,
                'error' => 400,
                'messages' => [
                    'error' => 'ID Pengguna dan ID Resep diperlukan.'
                ]
            ], 400);
        }

        $isFavorit = $this->model->where('id_pengguna', $data['id_pengguna'])
            ->where('id_resep', $data['id_resep'])
            ->first();

        return $this->respond([
            'status' => 200,
            'isFavorit' => $isFavorit ? true : false
        ], 200);
    }

    // public function check()
    // {
    //     $id_pengguna = $this->request->getPost('id_pengguna');
    //     $id_resep = $this->request->getPost('id_resep');

    //     if (empty($id_pengguna) || empty($id_resep)) {
    //         return $this->respond([
    //             'status' => 400,
    //             'error' => 400,
    //             'messages' => [
    //                 'error' => 'ID Pengguna dan ID Resep diperlukan.'
    //             ]
    //         ], 400);
    //     }

    //     $isFavorit = $this->model->where('id_pengguna', $id_pengguna)
    //         ->where('id_resep', $id_resep)
    //         ->first();

    //     return $this->respond([
    //         'status' => 200,
    //         'isFavorit' => $isFavorit ? true : false
    //     ], 200);
    // }
}
