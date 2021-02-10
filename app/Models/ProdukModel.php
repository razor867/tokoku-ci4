<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType     = 'object';
    protected $allowedFields = ['id', 'nama_produk', 'id_cat_produk', 'id_satuan', 'harga', 'stok'];

    public function getProduk()
    {
        $builder = $this->builder();
        $builder->select('produk.id, produk.nama_produk, produk.harga, produk.stok,
                        cat_produk.nama_category, satuan_produk.nama_satuan');
        $builder->join('cat_produk', 'cat_produk.id = produk.id_cat_produk', 'left');
        $builder->join('satuan_produk', 'satuan_produk.id = produk.id_satuan', 'left');
        $builder->orderBy('produk.nama_produk', 'DESC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function addProduk($data)
    {
        $builder = $this->builder();
        $builder->insert($data);
    }

    public function getLastID()
    {
        $builder = $this->builder();
        return $builder->countAll();
    }
}
