<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ResepModel;
use App\Models\PenggunaModel;
use App\Models\BahanResepModel;
use App\Models\LangkahResepModel;
use App\Models\ResepLikeModel;
use App\Models\KomentarModel;
use App\Models\ResepFavoritModel;
use App\Models\PenggunaFavoritModel;

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

    // public function detail($id_resep)
    // {
    //     $resepModel = new ResepModel();
    //     $penggunaModel = new PenggunaModel();
    //     $bahanModel = new BahanResepModel();
    //     $langkahModel = new LangkahResepModel();
    //     $likeModel = new ResepLikeModel();
    //     $komentarModel = new KomentarModel();
    //     $favoritModel = new ResepFavoritModel();
    //     $penggunaFavoritModel = new PenggunaFavoritModel();

    //     // Ambil data resep
    //     $resep = $resepModel->find($id_resep);

    //     // Ambil data user pembuat resep
    //     $pembuat = $penggunaModel->find($resep['id_pengguna']);

    //     // Ambil bahan-bahan resep
    //     $bahan = $bahanModel->where('id_resep', $id_resep)->findAll();

    //     // Ambil langkah-langkah resep
    //     $langkah = $langkahModel->where('id_resep', $id_resep)->orderBy('urutan', 'ASC')->findAll();

    //     // Ambil jumlah like
    //     $jumlah_like = $likeModel->where(['id_resep' => $id_resep, 'status' => 1])->countAllResults();

    //     // Ambil komentar
    //     $komentar = $komentarModel->where('id_resep', $id_resep)->findAll();

    //     // Cek apakah user sudah like, favorit, atau follow (jika sudah login)
    //     $user_id = session()->get('id_pengguna');
    //     $sudah_like = false;
    //     $sudah_favorit = false;
    //     $sudah_follow = false;

    //     if ($user_id) {
    //         $sudah_like = $likeModel->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep, 'status' => 1])->first() ? true : false;
    //         $sudah_favorit = $favoritModel->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep])->first() ? true : false;
    //         $sudah_follow = $penggunaFavoritModel->where(['id_pengguna' => $user_id, 'tambah_pengguna_favorit' => $pembuat['id_pengguna']])->first() ? true : false;
    //     }

    //     $data = [
    //         'resep' => $resep,
    //         'pembuat' => $pembuat,
    //         'bahan' => $bahan,
    //         'langkah' => $langkah,
    //         'jumlah_like' => $jumlah_like,
    //         'komentar' => $komentar,
    //         'sudah_like' => $sudah_like,
    //         'sudah_favorit' => $sudah_favorit,
    //         'sudah_follow' => $sudah_follow,
    //     ];

    //     return view('resep/detail', $data);
    // }
}
