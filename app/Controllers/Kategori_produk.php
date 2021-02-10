<?php

namespace App\Controllers;

use App\Models\KategoriProdukModel;

class kategori_produk extends BaseController
{
    protected $m_cat_produk;
    protected $validation;

    public function __construct()
    {
        $this->m_cat_produk = new KategoriProdukModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['title'] = 'Kategori Produk';
        $data['cat_produk'] = $this->m_cat_produk->findAll();
        $data['validation'] = $this->validation;
        return view('/kategori_produk/v_kategori_produk', $data);
    }

    public function addKategori()
    {
        if (!$this->validate($this->validation->getRuleGroup('kategori'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/kategori_produk')->withInput();
        }
        $category = $this->request->getPost('kategori');
        $deskripsi = $this->request->getPost('deskripsi');
        $this->m_cat_produk->save([
            'nama_category' => $category,
            'deskripsi' => $deskripsi
        ]);
        session()->setFlashdata('info', 'Data berhasil disimpan');
        return redirect()->to('/kategori_produk');
    }

    public function getRowKategori()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getpost('id');
            $query = $this->m_cat_produk->find($id);
            echo json_encode($query);
        } else {
            return redirect()->to('/kategori_produk');
        }
    }

    public function editKategori()
    {
        if (!$this->validate($this->validation->getRuleGroup('kategori'))) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/kategori_produk')->withInput();
        }
        $id = $this->request->getPost('id');
        $category = $this->request->getPost('kategori');
        $deskripsi = $this->request->getPost('deskripsi');
        $this->m_cat_produk->update($id, [
            'nama_category' => $category,
            'deskripsi' => $deskripsi
        ]);
        session()->setFlashdata('info', 'Data berhasil dirubah');
        return redirect()->to('/kategori_produk');
    }

    public function deleteKategori($id)
    {
        if (!preg_match('/^[0-9]*$/', $id)) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/kategori_produk');
        }
        $this->m_cat_produk->delete($id);
        session()->setFlashdata('info', 'Data berhasil dihapus');
        return redirect()->to('/kategori_produk');
    }
}
