<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriProdukModel extends Model
{
    protected $table = 'cat_produk';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['nama_category', 'deskripsi'];
}
