<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;
use App\Models\Serverside_model;
use CodeIgniter\I18n\Time;

class Penjualan extends BaseController
{
    protected $m_penjualan;
    protected $m_produk;
    protected $m_satuan;
    protected $validation;
    protected $serversideModel;
    protected $perm;
    protected $permAdd;
    protected $permEdit;
    protected $permDelete;

    public function __construct()
    {
        $this->m_penjualan = new PenjualanModel();
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->validation = \Config\Services::validation();
        $this->serversideModel = new Serverside_model();
        $this->perm =  has_permission('penjualan/page');
        $this->permAdd = has_permission('penjualan/add');
        $this->permEdit = has_permission('penjualan/edit');
        $this->permDelete = has_permission('penjualan/delete');
    }
    public function index()
    {
        $this->perm or exit();

        $data['produk'] = $this->m_produk->getProduk();
        $data['satuan'] = $this->m_satuan->findAll();
        $data['title'] = 'Penjualan';
        $data['validation'] = $this->validation;
        return view('penjualan/v_penjualan', $data);
    }

    public function addPenjualan()
    {
        $this->permAdd or exit();

        if (!$this->validate($this->validation->getRuleGroup('penjualan'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/penjualan')->withInput();
        }
        $produk = $this->request->getPost('produk');
        $satuan = $this->request->getPost('satuan');
        $qty = $this->request->getPost('qty');
        $total_jual = $this->request->getpost('total_jual');
        $time = new Time('now', 'Asia/Jakarta', 'id_ID');
        $time = date_format($time, 'd/m/Y H:i:s');

        $data = [
            'id_produk' => $produk,
            'id_satuan' => $satuan,
            'qty' => $qty,
            'total_jual' => $total_jual,
            'tanggal_jual' => $time
        ];

        $dataProduk = $this->m_produk->find($produk);
        if ($dataProduk->stok < 1 || $dataProduk->stok < $qty) {
            session()->setFlashdata('info', 'error_stok');
            return redirect()->to('/penjualan');
        } else {
            $this->m_penjualan->addDataPenjualan($data);
            $update_stok = $dataProduk->stok - $qty;
            $this->m_produk->update($produk, [
                'stok' => $update_stok
            ]);
            session()->setFlashdata('info', 'Data berhasil disimpan');
            return redirect()->to('/penjualan');
        }
    }

    public function getRowPenjualan()
    {
        $this->request->isAJAX() or exit();

        $id = $this->request->getPost('id');
        $query = $this->m_penjualan->find($id);
        echo json_encode($query);
    }

    public function editPenjualan()
    {
        $this->permEdit or exit();

        if (!$this->validate($this->validation->getRuleGroup('produk'))) {
            session()->setFlashdata('info', 'error_edit');
            return redirect()->to('/penjualan')->withInput();
        }
        $id = $this->request->getPost('id');
        $nama_produk = $this->request->getPost('nama_produk');
        $category = $this->request->getPost('category');
        $satuan = $this->request->getPost('satuan');
        $stok = $this->request->getpost('stok');
        $harga = $this->request->getPost('harga');

        $query = $this->m_penjualan->find($id);
        if ($query) {
            $this->m_produk->update($id, [
                'nama_produk' => $nama_produk,
                'id_cat_produk' => $category,
                'id_satuan' => $satuan,
                'harga' => $harga,
                'stok' => $stok,
            ]);
            session()->setFlashdata('info', 'Data berhasil dirubah');
        } else {
            session()->setFlashdata('info', 'error_edit');
        }

        return redirect()->to('/product');
    }

    public function deletePenjualan($id)
    {
        $this->permDelete or exit();

        if (!preg_match('/^[a-zA-Z0-9_]*$/', $id)) {
            session()->setFlashdata('info', 'error_delete');
            return redirect()->to('/penjualan');
        }

        $query = $this->m_penjualan->find($id);
        if ($query) {
            $this->m_penjualan->delete($id);
            session()->setFlashdata('info', 'Data berhasil di hapus');
        } else {
            session()->setFlashdata('info', 'error_delete');
        }

        return redirect()->to('/penjualan');
    }

    public function listdata()
    {
        $column_order = array('nama_produk', 'nama_satuan', 'qty', 'total_jual', 'tanggal_jual', 'id');
        $column_search = array('nama_produk', 'nama_satuan', 'qty', 'total_jual', 'tanggal_jual');
        $order = array('tanggal_jual' => 'desc');
        $list = $this->serversideModel->get_datatables('_data_penjualan', $column_order, $column_search, $order);
        $data = array();
        // $no = $this->request->getPost('start');
        foreach ($list as $lt) {
            $button_action = '<a href="#" class="btn btn-warning btn-circle edit" onclick="edit(\'' . $lt->id . '\')" data-toggle="modal" data-target="#penjualan_modal" title="Edit">
                                <i class="fas fa-exclamation-triangle"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-circle delete" onclick="deleteData(\'_datpen\',\'' . $lt->id . '\')" title="Delete">
                                <i class="fas fa-trash"></i>
                              </a>';
            $hasil_rupiah = "Rp" . number_format($lt->total_jual);

            $row = array();
            $row[] = $lt->nama_produk;
            $row[] = $lt->nama_satuan;
            $row[] = $lt->qty;
            $row[] = $hasil_rupiah;
            $row[] = $lt->tanggal_jual;
            $row[] = $button_action;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->serversideModel->count_all('_data_penjualan'),
            'recordsFiltered' => $this->serversideModel->count_filtered('_data_penjualan', $column_order, $column_search, $order),
            'data' => $data,
        );

        return json_encode($output);
    }
}
