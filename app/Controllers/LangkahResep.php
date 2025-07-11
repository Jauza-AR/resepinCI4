<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\LangkahResepModel;

class LangkahResep extends ResourceController
{
        public function byResep($id_resep)
    {
        $langkahModel = new LangkahResepModel();
        $langkah = $langkahModel->where('id_resep', $id_resep)->orderBy('urutan', 'ASC')->findAll();

        if (!$langkah) {
            return $this->failNotFound('Langkah untuk resep ini tidak ditemukan');
        }

        return $this->respond($langkah);
    }
}
