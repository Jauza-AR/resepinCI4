<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ResepLike extends ResourceController
{
    protected $modelName = 'App\Models\ResepLikeModel';
    protected $format    = 'json';

    public function likeResep()
{
    $id_pengguna = $this->request->getPost('id_pengguna');
    $id_resep    = $this->request->getPost('id_resep');
    $status      = $this->request->getPost('status'); // Ambil status dari request

    if (!$id_pengguna || !$id_resep || !isset($status)) {
        return $this->fail('id_pengguna, id_resep, dan status wajib diisi', 400);
    }

    // Cek apakah sudah ada like sebelumnya
    $like = $this->model
        ->where('id_pengguna', $id_pengguna)
        ->where('id_resep', $id_resep)
        ->first();

    if ($like) {
        // Jika sudah ada, update status sesuai input
        $this->model->update($like->id_like, ['status' => $status]);
    } else {
        // Jika belum ada, insert baru
        $this->model->insert([
            'id_pengguna' => $id_pengguna,
            'id_resep'    => $id_resep,
            'status'      => $status,
        ]);
    }

    return $this->respond(['message' => 'Status like berhasil diubah']);
}


}
