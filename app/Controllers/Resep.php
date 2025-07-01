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
use App\Models\PenggunaFavoritModel;
use App\Models\ResepFavoritModel;

use App\Entities\Resep as ResepEntity;
// use App\Models\ResepFavoritModel;

// use App\Models\PenggunaFavoritModel;
use CodeIgniter\API\ResponseTrait;
// use CodeIgniter\HTTP\Response;

class Resep extends ResourceController
{

    use ResponseTrait;

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

    public function populer()
    {
        // lama
        // 
        // $db = \Config\Database::connect();
        // $builder = $db->table('resep')
        //     ->select('resep.*, COUNT(resep_like.id_like) as jumlah_like')
        //     ->join('resep_like', 'resep.id_resep = resep_like.id_resep AND resep_like.status = 1', 'left')
        //     ->groupBy('resep.id_resep')
        //     ->orderBy('jumlah_like', 'DESC')
        //     ->limit(10);

        // $data = $builder->get()->getResult();
        // return $this->respond($data);

        $db = \Config\Database::connect();
        $builder = $db->table('resep')
            ->select('resep.id_resep, resep.nama_resep, resep.gambar, resep.kategori, resep.deskripsi, resep.tanggal_unggah, COUNT(resep_like.id_like) as jumlah_like')
            ->join('resep_like', 'resep.id_resep = resep_like.id_resep AND resep_like.status = 1', 'left')
            ->groupBy('resep.id_resep')
            ->orderBy('jumlah_like', 'DESC')
            ->limit(10);

        $data = $builder->get()->getResult();

        // if (!$data || count($data) === 0) 
        if (!$data) {
            // return $this->failNotFound('Resep populer tidak ditemukan');
            return $this->failServerError('Gagal mengambil data');
        }

        return $this->respond($data);
    }


    public function semuaByUser($id_pengguna)
    {
        $resepModel = new ResepModel();
        $likeModel = new ResepLikeModel();
        $favoritModel = new ResepFavoritModel();
        // LAma 
        // $reseps = $resepModel->findAll();
        // Baru
        $reseps = $resepModel->where('id_pengguna', $id_pengguna)->findAll();

        $result = [];

        foreach ($reseps as $resep) {
            // Gunakan object property, bukan array
            $jumlah_like = $likeModel->where(['id_resep' => $resep->id_resep, 'status' => 1])->countAllResults();

            $sudah_like = $likeModel
                ->where(['id_pengguna' => $id_pengguna, 'id_resep' => $resep->id_resep, 'status' => 1])
                ->first() ? true : false;

            $sudah_favorit = $favoritModel
                ->where(['id_pengguna' => $id_pengguna, 'id_resep' => $resep->id_resep])
                ->first() ? true : false;

            $result[] = [
                'id_resep'      => $resep->id_resep,
                'nama_resep'    => $resep->nama_resep,
                'gambar'        => $resep->gambar,
                'deskripsi'     => $resep->deskripsi,
                'jumlah_like'   => $jumlah_like,
                'sudah_like'    => $sudah_like,
                'sudah_favorit' => $sudah_favorit,
            ];
        }

        return $this->respond($result);
    }

    // Lama
    // public function byKategori($kategori)
    // Baru
    public function byKategori($kategori, $id_pengguna = null)
    {
        $resepModel = new ResepModel();
        $likeModel = new ResepLikeModel();
        $favoritModel = new ResepFavoritModel();

        // Ambil semua resep sesuai kategori
        $reseps = $resepModel->where('kategori', $kategori)->findAll();
        $user_id = session()->get('id_pengguna');
        $result = [];

        foreach ($reseps as $resep) {
            $jumlah_like = $likeModel->where(['id_resep' => $resep->id_resep, 'status' => 1])->countAllResults();

            $sudah_like = false;
            $sudah_favorit = false;

            if ($user_id) {
                $sudah_like = $likeModel
                    ->where(['id_pengguna' => $user_id, 'id_resep' => $resep->id_resep, 'status' => 1])
                    ->first() ? true : false;

                $sudah_favorit = $favoritModel
                    ->where(['id_pengguna' => $user_id, 'id_resep' => $resep->id_resep])
                    ->first() ? true : false;
            }

            $result[] = [
                'id_resep'      => $resep->id_resep,
                'nama_resep'    => $resep->nama_resep,
                'gambar'        => $resep->gambar,
                'deskripsi'     => $resep->deskripsi,
                'jumlah_like'   => $jumlah_like,
                'sudah_like'    => $sudah_like,
                'sudah_favorit' => $sudah_favorit,
            ];
        }
        return $this->respond($result);
    }

    public function create()
    {
        // //  ====== Lama ======
        // $data = $this->request->getPost();
        // $resep = new \App\Entities\Resep();
        // $resep->fill($data);

        // if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
        //     return $this->fail($this->validator->getErrors());
        // }
        // if ($this->model->save($resep)) {
        //     return $this->respondCreated($data, "Resep Berhasil Dibuat");
        // }
        // ====== Baru ======
        $resep = new ResepEntity();
        $resepModel = new ResepModel();
        $bahanModel = new BahanResepModel();
        $langkahModel = new LangkahResepModel();

        $request = service('request');

        $data = [
            'id_pengguna' => $request->getPost('id_pengguna'),
            'nama_resep' => $request->getPost('nama_resep'),
            'deskripsi' => $request->getPost('deskripsi'),
            'kategori' => $request->getPost('kategori'),
            'tanggal_unggah' => date('Y-m-d'),
            'gambar' => '',
        ];

        // Upload Gambar
        $gambar = $request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $namaGambar);
            $data['gambar'] = base_url('uploads/' . $namaGambar);
        } else {
            return $this->fail([
                'message' => 'Gagal Upload',
                'error' => $gambar ? $gambar->getErrorString() : 'Gambar Tidak Di temukan'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Validasi Gambar
        if (!$this->validateData($data, $resepModel->validationRules, $resepModel->validationMessages)) {
            return $this->fail([
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors(),
                'data_kirim' => $data
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Simpan Ke resep 
        $idResep = $resepModel->insert($data);
        if (!$idResep) {
            return $this->fail([
                'message' => 'Gagal Menyimpan Data',
                'errors' => $resepModel->errors(),
                'data_kirim' => $data,
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Ambil dan simpan  Bahan
        $bahanList = json_decode($request->getPost('bahan'), true);
        if (is_array($bahanList) && !empty($bahanList)) {
            foreach ($bahanList as $bahan) {
                if (is_string($bahan) && trim($bahan) !== '') {
                    $bahanModel->insert([
                        'id_resep' => $idResep,
                        'nama_bahan' => $bahan
                    ]);
                }
            }
        }
        $langkahRaw = $request->getPost('langkah');
        log_message('debug', 'Langkah : String Mentah (Raw) ' . ($langkahRaw ?? 'null'));

        $langkahList = json_decode($langkahRaw, true);
        log_message('debug', 'langkah hasil Decode' . json_encode($langkahList));

        if (is_array($langkahList) && !empty($langkahList)) {
            foreach ($langkahList as $i => $langkah) {
                if (is_string($langkah) && trim($langkah) !== '') {
                    $insertDataLangkah = [
                        'id_resep' => $idResep,
                        'urutan' => $i + 1,
                        'isi_langkah' => $langkah
                    ];
                    log_message('debug', 'langkah : insert dengan data' . json_encode($insertDataLangkah));
                    $insertlangkahResult = $langkahModel->insert($insertDataLangkah);
                    if (!$insertlangkahResult) {
                        log_message('error', 'Langkah  : Gagal Insert' . $langkah . 'Error Karena' . json_encode($langkahModel->errors()));
                    } else {
                        log_message('debug', 'langkah Berhasil di tambahkan' . $langkah . '(id Baru :' . $insertlangkahResult . ')');
                    }
                } else {
                    log_message('warning', 'Langkah Item Tidak Valid ' . json_encode($langkah));
                }
                // if(is_string($langkah) && trim($langkah) !== ''){
                //     $langkahModel->insert([
                //         'id_resep' => $idResep,
                //         'urutan' => $i + 1,
                //         'isi_langkah' => $langkah
                //     ]);
                // }
            }
        } else {
            log_message('warning', 'Langkah: Daftar tidak berbentuk array atau kosong setelah decode. LangkahRaw: ' . ($langkahRaw ?? 'null'));
        }
        // log_message('debug', 'END CREATE: Resep dan Detail Selesai Diproses');

        // Simpan bahan ke tabel bahan Resep 
        // Komen Coba
        // if (is_array($bahanList)){
        //     foreach($bahanList as $bahan){
        //         $bahanModel->insert([
        //             'id_resep' => $idResep,
        //             'nama_bahan' => $bahan
        //         ]);
        //     }
        // }

        // // Simpan langkah ke tabel langkah resep
        // // Komen Coba
        // if(is_array($langkahList)){
        //     foreach($langkahList as $i => $langkah){
        //         $langkahModel->insert([
        //             'id_resep' => $idResep,
        //             'urutan' => $i + 1,
        //             'isi_langkah' => $langkah

        //         ]);
        //     }
        // }
        return $this->respondCreated(['message' => 'Resep dan Detail Berhasi Disimpan', 'id_resep' => $idResep]);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_resep'] = $id;
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        // $pendaftaran = new \App\Entities\Resep();
        // $pendaftaran->fill($data);

        $resep = new ResepEntity();
        $resep->fill($data);
        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($resep)) {
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
    //     // $favoritModel = new ResepFavoritModel();
    //     // $penggunaFavoritModel = new PenggunaFavoritModel();

    //     // Ambil data resep
    //     $resep = $resepModel->find($id_resep);

    //     if (!$resep) {
    //         return $this->failNotFound('Resep Dengan ID' . $id_resep . "Tidak Di Temukan");
    //     }
    //     // Ambil data user pembuat resep
    //     $pembuat = $penggunaModel->find($resep->id_pengguna);

    //     // Nama pengguna
    //     // $nama_pengguna = $penggunaModel->select('nama_pengguna')
    //     //     ->where('id_pengguna', $resep->id_pengguna)
    //     //     ->first();

    //     // Ambil bahan-bahan resep
    //     $bahan = $bahanModel->where('id_resep', $id_resep)->findAll();

    //     // Ambil langkah-langkah resep
    //     $langkah = $langkahModel->where('id_resep', $id_resep)->orderBy('urutan', 'ASC')->findAll();

    //     // Ambil jumlah like
    //     $jumlah_like = $likeModel->where(['id_resep' => $id_resep, 'status' => 1])->countAllResults();

    //     // Ambil komentar
    //     // $komentar = $komentarModel->where('id_resep', $id_resep)->findAll();
    //     $komentar = $komentarModel->select('komentar.*, pengguna.nama_pengguna, pengguna.foto_profil')
    //         ->join('pengguna', 'pengguna.id_pengguna = komentar.id_pengguna')
    //         ->where('komentar.id_resep', $id_resep)
    //         ->findAll();

    //     // Cek apakah user sudah like, favorit, atau follow (jika sudah login)
    //     $user_id = session()->get('id_pengguna');
    //     $sudah_like = false;
    //     $sudah_favorit = false;
    //     $sudah_follow = false;

    //     if ($user_id) {
    //         $sudah_like = $likeModel->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep, 'status' => 1])->first() ? true : false;
    //         // $sudah_favorit = $favoritModel->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep])->first() ? true : false;
    //         // $sudah_follow = $penggunaFavoritModel->where(['id_pengguna' => $user_id, 'tambah_pengguna_favorit' => $pembuat['id_pengguna']])->first() ? true : false;
    //     }

    //     $data = [
    //         'resep' => $resep,
    //         'pembuat' => $pembuat,
    //         'nama_pengguna' => $pembuat->nama_pengguna,
    //         'bahan' => $bahan,
    //         'langkah' => $langkah,
    //         'jumlah_like' => $jumlah_like,
    //         'komentar' => $komentar,
    //         'sudah_like' => $sudah_like,
    //         'sudah_favorit' => $sudah_favorit,
    //         'sudah_follow' => $sudah_follow,
    //     ];

    //     return $this->respond($data);
    // }

    // public function detail($id){ // bagus error
    //     $resepModel = new ResepModel();
    //     $bahanModel = new BahanResepModel();
    //     $langkahModel = new LangkahResepModel();
    //     $penggunaModel = new PenggunaModel();
    //     $likeModel = new ResepLikeModel();
    //     $favoritModel = new ResepFavoritModel();
    //     $followModel = new PenggunaFavoritModel();



    //     $resep = $resepModel->find($id);
    //     if(!$resep) {
    //         return $this->failNotFound('Resep dengan ID ' . $id . ' tidak ditemukan');
    //     }

    //     $responseData = $resep->toArray();

    //     // Memasutukan Gamabar menyimpan
    //     if (!empty($resep->gambar)) {
    //          $responseData['gambar_resep'] = base_url('uploads/' . $resep->gambar);
    //     } else { 
    //       $responseData['gambar_resep'] = null;
    //     }



    //     // Tambah Nama Penulis
    //      $penulis = $penggunaModel->find($resep->id_pengguna);
    //      $responseData['penulis_resep'] = $penulis ? $penulis->nama_pengguna : 'Anonim';

    //     $data = [
    //         'resep' => $resep,
    //         'pembuat' => $pembuat,
    //         'nama_pengguna' => $pembuat->nama_pengguna,
    //         'bahan' => $bahan,
    //         'langkah' => $langkah,
    //         'jumlah_like' => $jumlah_like,
    //         'komentar' => $komentar,
    //         'sudah_like' => $sudah_like,
    //         'sudah_favorit' => $sudah_favorit,
    //         'sudah_follow' => $sudah_follow,
    //     ];

    //     //  Tambah BAhan
    //     $bahan = $bahanModel->where('id_resep', $id)->findAll();
    //     $responseData['bahan_resep'] = $bahan;

    //     // Tambah Langkah
    //      $langkah = $langkahModel->where('id_resep', $id)->orderBy('urutan', 'ASC')->findAll();
    //      $responseData['langkah_resep'] = $langkah;

    //     return $this->respond([
    //         'status' => true,
    //         'message' => 'Detail resep berhasil diambil',
    //         'data' => $responseData
    //     ]);


    //     // Get Langkah Dan Bahan
    //     // $bahan = $bahanModel->where('id_resep', $id)->findAll();
    //     // $langkah = $langkahModel->where('id_resep', $id)->orderBy('urutan', 'ASC')->findAll();

    //     // // Gabungkan Bahan Dan Langkah ke dalam Resep
    //     // $resep['bahan'] = $bahan;
    //     // $resep['langkah'] = $langkah;

    //     // return $this->respond([
    //     //     'status' => true,
    //     //     'message' => 'Detail resep berhasil diambil',
    //     //     'data' => $resep
    //     // ]);
    // }


    public function detail($id_resep)
    {
        $resepModel = new ResepModel();
        $penggunaModel = new PenggunaModel();
        $bahanModel = new BahanResepModel();
        $langkahModel = new LangkahResepModel();
        $likeModel = new ResepLikeModel();
        $favoritModel = new ResepFavoritModel();
        $penggunaFavoritModel = new PenggunaFavoritModel(); // jika ada tabel follow

        // Ambil data resep
        $resep = $resepModel->find($id_resep);
        if (!$resep) {
            return $this->failNotFound('Resep dengan ID ' . $id_resep . ' tidak ditemukan');
        }

        // Ambil data pembuat resep
        $pembuat = $penggunaModel->find($resep->id_pengguna);

        // Ambil bahan dan langkah
        $bahan = $bahanModel->where('id_resep', $id_resep)->findAll();
        $langkah = $langkahModel->where('id_resep', $id_resep)->orderBy('urutan', 'ASC')->findAll();

        // Jumlah like
        $jumlah_like = $likeModel->where(['id_resep' => $id_resep, 'status' => 1])->countAllResults();

        // Ambil id pengguna yang sedang melihat (dari session atau request)
        $user_id = $this->request->getGet('id_pengguna') ?? session()->get('id_pengguna');
        $sudah_like = false;
        $sudah_favorit = false;
        $sudah_follow = false;

        if ($user_id) {
            $sudah_like = $likeModel
                ->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep, 'status' => 1])
                ->first() ? true : false;

            $sudah_favorit = $favoritModel
                ->where(['id_pengguna' => $user_id, 'id_resep' => $id_resep])
                ->first() ? true : false;

            // Jika ada tabel follow, cek status follow
            $sudah_follow = $penggunaFavoritModel
                ->where(['id_pengguna' => $user_id, 'tambah_pengguna_favorit' => $pembuat->id_pengguna])
                ->first() ? true : false;
        }

        $data = [
            'id_resep'        => $resep->id_resep,
            'nama_resep'      => $resep->nama_resep,
            'gambar'          => $resep->gambar,
            'waktu_unggah'    => $resep->tanggal_unggah ?? $resep->waktu_unggah ?? null,
            'deskripsi'       => $resep->deskripsi,
            'jumlah_like'     => $jumlah_like,
            'sudah_like'      => $sudah_like,
            'sudah_favorit'   => $sudah_favorit,
            'id_pengguna'     => $pembuat->id_pengguna ?? null,
            'nama_pengguna'   => $pembuat->nama_pengguna ?? null,
            'sudah_follow'    => $sudah_follow,
            'bahan'           => $bahan,
            'langkah'         => $langkah,
        ];

        return $this->respond($data);
    }

    public function getByUser($id_pengguna = null)
    {
        if (!$id_pengguna) {
            return $this->failValidationErrors('ID Pengguna harus diisi.');
        }

        $builder = $this->model
            ->select('resep.*, pengguna.nama_pengguna, pengguna.foto_profil')
            ->join('pengguna', 'pengguna.id_pengguna = resep.id_pengguna')
            ->where('resep.id_pengguna', $id_pengguna);

        $data = $builder->findAll();

        if (empty($data)) {
            return $this->failNotFound('Tidak ada resep yang ditemukan untuk pengguna dengan ID: ' . $id_pengguna);
        }

        return $this->respond($data);
    }
}
