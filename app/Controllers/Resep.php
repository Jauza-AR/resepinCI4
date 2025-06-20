<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Resep extends ResourceController
{
    protected $modelName = 'App\Models\ResepModel';
    protected $format = 'json';
    public function index()
    {
        $data = $this->model->findAll();
        return $this->response->setJSON($data);
    }

    public function show($id = null)
    {
        $builder = $this->model
            ->select('resep.*, pengguna.nama_pengguna, pengguna.foto_profil')
            ->join('pengguna', 'pengguna.id_pengguna = resep.id_pengguna')
            ->where('resep.id_resep', $id);

        $data = $builder->first();

        if (!$data) {
            return $this->fail('Data tidak ditemukan');
        }
        return $this->respond($data);
    }
    public function create()
    {
        $data = $this->request->getPost();
        $resep = new \App\Entities\Resep();
        $resep->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resep)) {
            return $this->respondCreated($data, "Resep Berhasil Dibuat");
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_resep'] = $id;
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        $pendaftaran = new \App\Entities\Resep();
        $pendaftaran->fill($data);
        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($pendaftaran)) {
            return $this->respondUpdated($data, "Pendaftaran Berhasil Diupdate");
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

    public function populer()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('resep')
            ->select('resep.*, COUNT(resep_like.id_like) as jumlah_like')
            ->join('resep_like', 'resep.id_resep = resep_like.id_resep AND resep_like.status = 1', 'left')
            ->groupBy('resep.id_resep')
            ->orderBy('jumlah_like', 'DESC')
            ->limit(10);

        $data = $builder->get()->getResult();
        return $this->respond($data);
    }
}
