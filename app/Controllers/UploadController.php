<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UploadController extends ResourceController
{
    public function index()
    {
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'writable/uploads', $newName);

            // Simpan nama file ke database
            $db = \Config\Database::connect();
            $db->table('gambar')->insert([
                'nama_file' => $newName,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return $this->respond(['status' => 'success', 'nama_file' => $newName]);
        }

        return $this->fail('Gagal mengunggah file');
    }

    public function uploadFoto()
    {
        $file = $this->request->getFile('gambar');
        $id_pengguna = $this->request->getPost('id_pengguna');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'writable/uploads', $newName);

            // Simpan nama file ke pengguna
            $penggunaModel = new \App\Models\PenggunaModel();
            $penggunaModel->update($id_pengguna, [
                'foto' => $newName
            ]);

            return $this->respond([
                'status' => 'success',
                'message' => 'Foto berhasil diunggah',
                'nama_file' => $newName
            ]);
        }

        return $this->fail('Upload gagal');
    }
}
