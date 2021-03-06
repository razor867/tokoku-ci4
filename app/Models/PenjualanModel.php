<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['id_produk', 'id_satuan', 'qty', 'total_jual', 'tanggal_jual'];

    public function getPenjualan()
    {
        $builder = $this->builder();
        $builder->select('penjualan.id, penjualan.qty, penjualan.total_jual, penjualan.tanggal_jual,
                        produk.nama_produk, satuan_produk.nama_satuan');
        $builder->join('produk', 'produk.id = penjualan.id_produk', 'left');
        $builder->join('satuan_produk', 'satuan_produk.id = penjualan.id_satuan', 'left');
        $builder->orderBy('penjualan.tanggal_jual', 'DESC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function addDataPenjualan($data)
    {
        $builder = $this->builder();
        $builder->insert($data);
    }
}
