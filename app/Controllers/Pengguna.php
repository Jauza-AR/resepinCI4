<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Pengguna extends ResourceController
{
    protected $modelName = 'App\Models\PenggunaModel';
    protected $format    = 'json';
    public function index()
    {
        $data = $this->model->findAll();
        return $this->response->setJSON($data);
    }

    public function show($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        return $this->respond($this->model->find($id));
    }

    public function create()
    {
        $data = $this->request->getPost();
        $resep = new \App\Entities\Pengguna();
        $resep->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resep)) {
            return $this->respondCreated($data, "Resgistrasi Pengguna Berhasil");
        }
    }

    // public function update($id = null)
    // {
    //     $data = $this->request->getRawInput();
    //     $data['id_pengguna'] = $id;
    //     if (!$this->model->find($id)) {
    //         return $this->fail('Data tidak ditemukan');
    //     }
    //     $pendaftaran = new \App\Entities\Pengguna();
    //     $pendaftaran->fill($data);
    //     if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
    //         return $this->fail($this->validator->getErrors());
    //     }
    //     if ($this->model->save($pendaftaran)) {
    //         return $this->respondUpdated($data, "Data Berhasil Diupdate");
    //     }
    // }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_pengguna'] = $id;

        if (!$this->model->find($id)) {
            return $this->failNotFound('Pengguna tidak ditemukan');
        }

        $pengguna = new \App\Entities\Pengguna();
        $pengguna->fill($data);

        // Validasi hanya field yang dikirim
        $rules = [];

        foreach ($this->model->validationRules as $field => $rule) {
            if (array_key_exists($field, $data)) {
                $rules[$field] = $rule;
            }
        }

        if (!empty($rules)) {
            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
        }

        if ($this->model->save($pengguna)) {
            return $this->respondUpdated($data, 'Data berhasil diupdate');
        } else {
            return $this->fail($this->model->db->error()['message']);
        }
    }


    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        if ($this->model->delete($id)) {
            return $this->respondDeleted("Pengguna dengan ID $id telah dihapus");
        }
    }
}
