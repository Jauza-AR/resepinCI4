<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Komentar extends ResourceController
{
    protected $modelName = 'App\Models\KomentarModel';
    protected $format    = 'json';

    // GET /komentar
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Komentar tidak ditemukan');
        }
        return $this->respond($data);
    }
    public function new()
    {
        //
    }

    public function create()
    {
        $input = $this->request->getPost();

        if (!$this->model->insert($input)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated($input, 'Komentar berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        //
    }

    // public function update($id = null)
    // {
    //     $input = $this->request->getRawInput();

    //     if (!$this->model->find($id)) {
    //         return $this->failNotFound('Komentar tidak ditemukan');
    //     }

    //     if (!$this->model->update($id, $input)) {
    //         return $this->failValidationErrors($this->model->errors());
    //     }

    //     return $this->respond($input, 200, 'Komentar berhasil diupdate');
    // }



    public function byResep($id_resep = null)
    {
        if (!$id_resep) {
            return $this->failValidationErrors('id_resep wajib diisi');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('komentar');
        $builder->select('komentar.*, pengguna.nama_pengguna, pengguna.foto_profil');
        $builder->join('pengguna', 'pengguna.id_pengguna = komentar.id_pengguna');
        $builder->where('komentar.id_resep', $id_resep);
        $builder->orderBy('waktu_komentar', 'DESC');
        $query = $builder->get();
        $data = $query->getResult();

        return $this->respond($data);
    }

}
