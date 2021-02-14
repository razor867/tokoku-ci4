<?php

namespace App\Controllers;

use App\Models\PembelianModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;
use CodeIgniter\I18n\Time;

class Pembelian extends BaseController
{
    protected $m_pembelian;
    protected $m_produk;
    protected $m_satuan;
    protected $validation;

    public function __construct()
    {
        $this->m_pembelian = new PembelianModel();
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data['produk'] = $this->m_produk->getProduk();
        $data['satuan'] = $this->m_satuan->findAll();
        $data['pembelian'] = $this->m_pembelian->getPembelian();
        $data['title'] = 'Pembelian';
        $data['validation'] = $this->validation;
        return view('pembelian/v_pembelian', $data);
    }

    public function addPembelian()
    {
        if (!$this->validate($this->validation->getRuleGroup('pembelian'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/pembelian')->withInput();
        }
        $produk = $this->request->getPost('produk');
        $satuan = $this->request->getPost('satuan');
        $qty = $this->request->getPost('qty');
        $total_beli = $this->request->getpost('total_beli');
        $time = new Time('now', 'Asia/Jakarta', 'id_ID');
        $time = date_format($time, 'd/m/Y H:i:s');

        $data = [
            'id_produk' => $produk,
            'id_satuan' => $satuan,
            'qty' => $qty,
            'total_beli' => $total_beli,
            'tanggal_beli' => $time
        ];

        $this->m_pembelian->addDataPembelian($data);
        $oldStok = $this->m_produk->find($produk);
        $updateStok = $oldStok->stok + $qty;
        $this->m_produk->update($produk, ['stok' => $updateStok]);
        session()->setFlashdata('info', 'Data berhasil disimpan');
        return redirect()->to('/pembelian');
    }

    public function getRowPembelian()
    {
        $id = $this->request->getPost('id');
        $query = $this->m_pembelian->find($id);
        echo json_encode($query);
    }

    public function editPembelian()
    {
        if (!$this->validate($this->validation->getRuleGroup('pembelian'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/pembelian')->withInput();
        }
        $id = $this->request->getPost('id');
        if (empty($id)) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/pembelian');
        }

        $produk = $this->request->getPost('produk');
        $satuan = $this->request->getPost('satuan');
        $qty = $this->request->getPost('qty');
        $total_beli = $this->request->getpost('total_beli');
        $time = new Time('now', 'Asia/Jakarta', 'id_ID');
        $time = date_format($time, 'd/m/Y H:i:s');

        $oldQtyPembelian = $this->m_pembelian->find($id);
        $stokProduk = $this->m_produk->find($produk);
        $updateStok = $stokProduk->stok - $oldQtyPembelian->qty;

        $this->m_pembelian->update($id, [
            'id_produk' => $produk,
            'id_satuan' => $satuan,
            'qty' => $qty,
            'total_beli' => $total_beli,
            'tanggal_beli' => $time
        ]);
        $updateStok = $updateStok + $qty;
        $this->m_produk->update($produk, ['stok' => $updateStok]);
        session()->setFlashdata('info', 'Data berhasil dirubah');
        return redirect()->to('/pembelian');
    }

    public function deletePembelian($id)
    {
        if (!preg_match('/^[a-zA-Z0-9_]*$/', $id)) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/pembelian');
        }
        $this->m_pembelian->delete($id);
        session()->setFlashdata('info', 'Data berhasil di hapus');
        return redirect()->to('/pembelian');
    }
}
