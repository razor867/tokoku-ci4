<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\SatuanModel;
use App\Models\KategoriProdukModel;

class Product extends BaseController
{
    protected $m_produk;
    protected $m_satuan;
    protected $m_cat_produk;
    protected $validation;
    public function __construct()
    {
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->m_cat_produk = new KategoriProdukModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data['produk'] = $this->m_produk->getProduk();
        $data['satuan'] = $this->m_satuan->findAll();
        $data['cat_produk'] = $this->m_cat_produk->findAll();
        $data['title'] = 'Produk';
        $data['validation'] = $this->validation;
        return view('produk/v_produk', $data);
    }

    public function addProduct()
    {
        if (!$this->validate($this->validation->getRuleGroup('produk'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/product')->withInput();
        }
        $nama_produk = $this->request->getPost('nama_produk');
        $category = $this->request->getPost('category');
        $satuan = $this->request->getPost('satuan');
        $stok = $this->request->getpost('stok');
        $harga = $this->request->getPost('harga');

        $lastid = $this->m_produk->getLastID();
        $row = $lastid + 1;
        $nomor = str_pad($row, 6, "0", STR_PAD_LEFT);
        $kode = "P" . $nomor;
        $data = [
            'id' => $kode,
            'nama_produk' => $nama_produk,
            'id_cat_produk' => $category,
            'id_satuan' => $satuan,
            'harga' => $harga,
            'stok' => $stok
        ];
        $this->m_produk->addProduk($data);
        session()->setFlashdata('info', 'Data berhasil disimpan');
        return redirect()->to('/product');
    }

    public function getRowProduct()
    {
        $id = $this->request->getPost('id');
        $query = $this->m_produk->find($id);
        echo json_encode($query);
    }

    public function editProduct()
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

    public function deleteProduct($id)
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
