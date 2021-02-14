<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['id_produk', 'id_satuan', 'qty', 'total_beli', 'tanggal_beli'];

    public function getPembelian()
    {
        $builder = $this->builder();
        $builder->select('pembelian.id, pembelian.qty, pembelian.total_beli, pembelian.tanggal_beli,
                        produk.nama_produk, satuan_produk.nama_satuan');
        $builder->join('produk', 'produk.id = pembelian.id_produk', 'left');
        $builder->join('satuan_produk', 'satuan_produk.id = pembelian.id_satuan', 'left');
        $builder->orderBy('pembelian.tanggal_beli', 'DESC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function addDataPembelian($data)
    {
        $builder = $this->builder();
        $builder->insert($data);
    }
}
