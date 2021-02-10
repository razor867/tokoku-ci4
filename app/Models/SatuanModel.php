<?php

namespace App\Models;

use CodeIgniter\Model;

class SatuanModel extends Model
{
    protected $table = 'satuan_produk';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['nama_satuan', 'deskripsi'];
}
