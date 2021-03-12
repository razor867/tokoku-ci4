<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\SatuanModel;
use App\Models\KategoriProdukModel;
use App\Models\Serverside_model;

class Product extends BaseController
{
    protected $m_produk;
    protected $m_satuan;
    protected $m_cat_produk;
    protected $validation;
    protected $serversideModel;

    public function __construct()
    {
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->m_cat_produk = new KategoriProdukModel();
        $this->validation = \Config\Services::validation();
        $this->serversideModel = new Serverside_model();
    }
    public function index()
    {
        $data['satuan'] = $this->m_satuan->findAll();
        $data['cat_produk'] = $this->m_cat_produk->findAll();
        $data['title'] = 'Produk';
        $data['validation'] = $this->validation;
        return view('produk/v_produk', $data);
    }


    public function listdata()
    {
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('nama_produk', 'nama_category', 'nama_satuan', 'harga', 'stok', 'id');
        $column_search = array('nama_produk', 'nama_category', 'nama_satuan', 'harga', 'stok');
        $order = array('nama_produk' => 'asc');
        $list = $this->serversideModel->get_datatables('_data_produk', $column_order, $column_search, $order);
        $data = array();
        // $no = $this->request->getPost('start');
        foreach ($list as $lt) {
            $button_action = '<a href="#" class="btn btn-warning btn-circle edit" onclick="edit(\'' . $lt->id . '\')" data-toggle="modal" data-target="#product_modal" title="Edit">
                                <i class="fas fa-exclamation-triangle"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-circle delete" onclick="deleteData(\'_product\',\'' . $lt->id . '\')" title="Delete">
                                <i class="fas fa-trash"></i>
                              </a>';
            $hasil_rupiah = "Rp" . number_format($lt->harga);

            $row = array();
            $row[] = (empty($lt->nama_produk)) ? $lt->nama_produk . '<br><span class="badge badge-danger">Empty</span>' : $lt->nama_produk . '<br><span class="badge badge-success">Available</span>';
            $row[] = $lt->nama_category;
            $row[] = $lt->nama_satuan;
            $row[] = $hasil_rupiah;
            $row[] = $lt->stok;
            $row[] = $button_action;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->serversideModel->count_all('_data_produk'),
            'recordsFiltered' => $this->serversideModel->count_filtered('_data_produk', $column_order, $column_search, $order),
            'data' => $data,
        );

        return json_encode($output);
    }

    public function addProduct()
    {
        if (!$this->validate($this->validation->getRuleGroup('produk'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/product')->withInput();
        }
        $nama_produk = $this->request->getPost('nama_produk');
        $category = $this->request->getPost('category');
        $satuan = $this->request->getPost('satuan');
        $stok = $this->request->getpost('stok');
        $harga = $this->request->getPost('harga');

        $lastid = '';
        $lastData = $this->m_produk->getLastID();
        foreach ($lastData as $ld) {
            $lastid = $ld->id;
        }

        $pattern = '/([^0-9]+)/';
        $lastid = preg_replace($pattern, '', $lastid);

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
            session()->setFlashdata('info', 'error_edit');
            return redirect()->to('/product')->withInput();
        }
        $id = $this->request->getPost('id');
        $nama_produk = $this->request->getPost('nama_produk');
        $category = $this->request->getPost('category');
        $satuan = $this->request->getPost('satuan');
        $stok = $this->request->getpost('stok');
        $harga = $this->request->getPost('harga');

        $idData = $this->m_produk->find($id);
        if ($idData) {
            $this->m_produk->update($id, [
                'nama_produk' => $nama_produk,
                'id_cat_produk' => $category,
                'id_satuan' => $satuan,
                'harga' => $harga,
                'stok' => $stok,
            ]);
            session()->setFlashdata('info', 'Data berhasil dirubah');
        } else {
            session()->setFlashdata('info', 'error');
        }
        return redirect()->to('/product');
    }

    public function deleteProduct($id)
    {
        if (!preg_match('/^[a-zA-Z0-9_]*$/', $id)) {
            session()->setFlashdata('info', 'error_delete');
            return redirect()->to('/product');
        }
        $idData = $this->m_produk->find($id);
        if ($idData) {
            $this->m_produk->delete($id);
            session()->setFlashdata('info', 'Data berhasil di hapus');
        } else {
            session()->setFlashdata('info', 'error_delete');
        }

        return redirect()->to('/product');
    }
}
