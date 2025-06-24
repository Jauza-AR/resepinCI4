<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Pengguna extends ResourceController
{
    protected $modelName = 'App\Models\PenggunaModel';
    protected $format    = 'json';

    public function me()
    {
        $id_pengguna = session()->get('id_pengguna');
        if (!$id_pengguna) {
            return $this->failUnauthorized('Anda harus login terlebih dahulu');
        }

        $data = $this->model->find($id_pengguna);
        if (!$data) {
            return $this->failNotFound('Pengguna tidak ditemukan');
        }

        return $this->respond($data);
    }

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

        // Hash password sebelum simpan
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $resep = new \App\Entities\Pengguna();
        $resep->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resep)) {
            return $this->respondCreated($data, "Registrasi Pengguna Berhasil");
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_pengguna'] = $id;
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        $pendaftaran = new \App\Entities\Pengguna();
        $pendaftaran->fill($data);
        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($pendaftaran)) {
            return $this->respondUpdated($data, "Data Berhasil Diupdate");
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

    // public function login()
    // {
    //     $data = $this->request->getPost();
    //     $user = $this->model->where('email', $data['email'])->first();

    //     if (!$user) {
    //         return $this->fail('email tidak ditemukan');
    //     }

    //     if (!password_verify($data['password'], $user->password)) {
    //         return $this->fail('Password salah');
    //     }

    //     // Set session
    //     session()->set([
    //         'id_pengguna'   => $user->id_pengguna,
    //         'email' => $user->email,
    //         'logged_in'     => true
    //     ]);

    //     return $this->respond(['message' => 'Login berhasil']);
    // }



    //Loggin jadi

    // public function login()
    // {
    //     $rules = [
    //         'email'    => 'required|valid_email',
    //         'password' => 'required'
    //     ];

    //     if (!$this->validate($rules)) {
    //         return $this->fail($this->validator->getErrors());
    //     }

    //     $data = $this->request->getPost();
    //     $user = $this->model->where('email', $data['email'])->first();

    //     if (!$user) {
    //         return $this->failUnauthorized('Email tidak ditemukan');
    //     }

    //     if (!password_verify($data['password'], $user->password)) {
    //         return $this->failUnauthorized('Password salah');
    //     }

    //     session()->set([
    //         'id_pengguna'   => $user->id_pengguna,
    //         'email'         => $user->email,
    //         'logged_in'     => true
    //     ]);

    //     return $this->respond(['message' => 'Login berhasil']);
    // }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $user = $this->model->where('email', $data['email'])->first();

        if (!$user) {
            return $this->failUnauthorized('Email tidak ditemukan');
        }

        if (!password_verify($data['password'], $user->password)) {
            return $this->failUnauthorized('Password salah');
        }

        session()->set([
            'id_pengguna'   => $user->id_pengguna,
            'email'         => $user->email,
            'nama_pengguna' => $user->nama_pengguna,
            'logged_in'     => true
        ]);

        // Ubah entity ke array jika perlu
        $userData = [
            'id_pengguna'   => $user->id_pengguna,
            'nama_pengguna' => $user->nama_pengguna,
            'email'         => $user->email,
            'bio'           => $user->bio ?? null,
            'foto_profil'   => $user->foto_profil ?? null,
            // tambahkan field lain jika ada
        ];

        return $this->respond([
            'message' => 'Login berhasil',
            'user'    => $userData
        ]);
    }
}
