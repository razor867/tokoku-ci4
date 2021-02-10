<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;

class Penjualan extends BaseController
{
    protected $m_penjualan;
    protected $m_produk;
    protected $m_satuan;
    protected $validation;

    public function __construct()
    {
        $this->m_penjualan = new PenjualanModel();
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data['produk'] = $this->m_produk->getProduk();
        $data['satuan'] = $this->m_satuan->findAll();
        $data['penjualan'] = $this->m_penjualan->getPenjualan();
        $data['title'] = 'Penjualan';
        $data['validation'] = $this->validation;
        return view('penjualan/v_penjualan', $data);
    }

    public function addPenjualan()
    {
        if (!$this->validate($this->validation->getRuleGroup('penjualan'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/penjualan')->withInput();
        }
        $produk = $this->request->getPost('produk');
        $satuan = $this->request->getPost('satuan');
        $qty = $this->request->getPost('qty');
        $total_jual = $this->request->getpost('total_jual');
        $this->m_penjualan->save([
            'id_produk' => $produk,
            'id_satuan' => $satuan,
            'qty' => $qty,
            'total_jual' => $total_jual
        ]);

        session()->setFlashdata('info', 'Data berhasil disimpan');
        return redirect()->to('/penjualan');
    }

    public function getRowPenjualan()
    {
        $id = $this->request->getPost('id');
        $query = $this->m_produk->find($id);
        echo json_encode($query);
    }

    public function editPenjualan()
    {
        if (!$this->validate($this->validation->getRuleGroup('produk'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/product')->withInput();
        }
        $id = $this->request->getPost('id');
        $nama_produk = $this->request->getPost('nama_produk');
        $category = $this->request->getPost('category');
        $satuan = $this->request->getPost('satuan');
        $stok = $this->request->getpost('stok');
        $harga = $this->request->getPost('harga');

        $this->m_produk->update($id, [
            'nama_produk' => $nama_produk,
            'id_cat_produk' => $category,
            'id_satuan' => $satuan,
            'harga' => $harga,
            'stok' => $stok,
        ]);
        session()->setFlashdata('info', 'Data berhasil dirubah');
        return redirect()->to('/product');
    }

    public function deletePenjualan($id)
    {
        if (!preg_match('/^[a-zA-Z0-9_]*$/', $id)) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/product');
        }
        $this->m_produk->delete($id);
        session()->setFlashdata('info', 'Data berhasil di hapus');
        return redirect()->to('/product');
    }
}
