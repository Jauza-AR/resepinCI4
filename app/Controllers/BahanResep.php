<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\BahanResepModel;

class BahanResep extends ResourceController
{
        public function byResep($id_resep)
    {
        $bahanModel = new BahanResepModel();
        $bahan = $bahanModel->where('id_resep', $id_resep)->findAll();

        if (!$bahan) {
            return $this->failNotFound('Bahan untuk resep ini tidak ditemukan');
        }

        return $this->respond($bahan);
    }
}
