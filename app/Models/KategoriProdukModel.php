<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriProdukModel extends Model
{
    protected $table = 'cat_produk';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['nama_category', 'deskripsi'];

    public function get_total_catproduk($category)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('_data_produk');
        $data = $builder->where('nama_category', $category);
        return count($data->get()->getResult());
    }
}
