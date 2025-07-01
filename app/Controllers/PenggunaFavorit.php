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
        // JOIN ke tabel pengguna untuk ambil detail
        $favorit = $this->model
            ->select('pengguna_favorit.*, pengguna.nama_pengguna, pengguna.foto_profil, pengguna.bio')
            ->join('pengguna', 'pengguna.id_pengguna = pengguna_favorit.tambah_pengguna_favorit')
            ->where('pengguna_favorit.id_pengguna', $id_pengguna)
            ->findAll();

        // Hapus field id_pengguna_favorit dari setiap item
        foreach ($favorit as &$item) {
            unset($item['id_pengguna_favorit']);
        }

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

    public function followByResep()
    {
        $resepId = $this->request->getPost('idresep');
        $currentUserId = $this->request->getPost('id_pengguna'); // input eksplisit

        $resepModel = new \App\Models\ResepModel();
        $followModel = new \App\Models\PenggunaFavoritModel();

        $resep = $resepModel->find($resepId);
        if (!$resep) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Resep tidak ditemukan']);
        }

        $targetUserId = $resep['id_pengguna'];

        if (!$currentUserId) {
            return $this->response->setStatusCode(401)->setJSON(['message' => 'ID pengguna tidak valid']);
        }

        if ($currentUserId == $targetUserId) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Tidak bisa mengikuti diri sendiri']);
        }

        $alreadyFollow = $followModel
            ->where('id_pengguna', $currentUserId)
            ->where('tambah_pengguna_favorit', $targetUserId)
            ->first();

        if ($alreadyFollow) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Sudah mengikuti pengguna ini']);
        }

        $followModel->insert([
            'id_pengguna' => $currentUserId,
            'tambah_pengguna_favorit' => $targetUserId,
        ]);

        return $this->response->setJSON(['message' => 'Berhasil mengikuti pengguna']);
    }

    public function unfollowByResep()
    {
        $resepId = $this->request->getPost('idresep');
        $currentUserId = $this->request->getPost('id_pengguna'); // input eksplisit

        $resepModel = new \App\Models\ResepModel();
        $followModel = new \App\Models\PenggunaFavoritModel();

        $resep = $resepModel->find($resepId);
        if (!$resep) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Resep tidak ditemukan']);
        }

        $targetUserId = $resep['id_pengguna'];

        if (!$currentUserId) {
            return $this->response->setStatusCode(401)->setJSON(['message' => 'ID pengguna tidak valid']);
        }

        if ($currentUserId == $targetUserId) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Tidak bisa unfollow diri sendiri']);
        }

        $followRecord = $followModel
            ->where('id_pengguna', $currentUserId)
            ->where('tambah_pengguna_favorit', $targetUserId)
            ->first();

        if (!$followRecord) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Belum mengikuti pengguna ini']);
        }

        $followModel
            ->where('id_pengguna', $currentUserId)
            ->where('tambah_pengguna_favorit', $targetUserId)
            ->delete();

        return $this->response->setJSON(['message' => 'Berhasil berhenti mengikuti pengguna']);
    }

    public function cekFollow($id_pengguna = null, $tambah_pengguna_favorit = null)
    {
        if (!$id_pengguna || !$tambah_pengguna_favorit) {
            return $this->fail('Parameter tidak lengkap');
        }

        $follow = $this->model
            ->where('id_pengguna', $id_pengguna)
            ->where('tambah_pengguna_favorit', $tambah_pengguna_favorit)
            ->first();

        return $this->respond([
            'sudah_follow' => $follow ? true : false
        ]);
    }
}
