<?php

namespace App\Controllers;

use App\Models\PembelianModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;
use App\Models\Serverside_model;
use CodeIgniter\I18n\Time;

class Pembelian extends BaseController
{
    protected $m_pembelian;
    protected $m_produk;
    protected $m_satuan;
    protected $validation;
    protected $serversideModel;

    public function __construct()
    {
        $this->m_pembelian = new PembelianModel();
        $this->m_produk = new ProdukModel();
        $this->m_satuan = new SatuanModel();
        $this->validation = \Config\Services::validation();
        $this->serversideModel = new Serverside_model();
    }
    public function index()
    {
        $data['produk'] = $this->m_produk->getProduk();
        $data['satuan'] = $this->m_satuan->findAll();
        $data['title'] = 'Pembelian';
        $data['validation'] = $this->validation;
        return view('pembelian/v_pembelian', $data);
    }

    public function addPembelian()
    {
        if (!$this->validate($this->validation->getRuleGroup('pembelian'))) {
            session()->setFlashdata('info', 'error_add');
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
            session()->setFlashdata('info', 'error_edit');
            return redirect()->to('/pembelian')->withInput();
        }
        $id = $this->request->getPost('id');

        $produk = $this->request->getPost('produk');
        $satuan = $this->request->getPost('satuan');
        $qty = $this->request->getPost('qty');
        $total_beli = $this->request->getpost('total_beli');
        $time = new Time('now', 'Asia/Jakarta', 'id_ID');
        $time = date_format($time, 'd/m/Y H:i:s');

        $oldQtyPembelian = $this->m_pembelian->find($id);
        $stokProduk = $this->m_produk->find($produk);
        $updateStok = $stokProduk->stok - $oldQtyPembelian->qty;

        $query = $this->m_pembelian->find($id);
        if ($query) {
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
        } else {
            session()->setFlashdata('info', 'error_edit');
        }

        return redirect()->to('/pembelian');
    }

    public function deletePembelian($id)
    {
        if (!preg_match('/^[a-zA-Z0-9_]*$/', $id)) {
            session()->setFlashdata('info', 'error_delete');
            return redirect()->to('/pembelian');
        }

        $query = $this->m_pembelian->find($id);
        if ($query) {
            $this->m_pembelian->delete($id);
            session()->setFlashdata('info', 'Data berhasil di hapus');
        } else {
            session()->setFlashdata('info', 'error_delete');
        }

        return redirect()->to('/pembelian');
    }

    public function listdata()
    {
        $column_order = array('nama_produk', 'nama_satuan', 'qty', 'total_beli', 'tanggal_beli', 'id');
        $column_search = array('nama_produk', 'nama_satuan', 'qty', 'total_beli', 'tanggal_beli');
        $order = array('tanggal_beli' => 'desc');
        $list = $this->serversideModel->get_datatables('_data_pembelian', $column_order, $column_search, $order);
        $data = array();
        // $no = $this->request->getPost('start');
        foreach ($list as $lt) {
            $button_action = '<a href="#" class="btn btn-warning btn-circle edit" onclick="edit(\'' . $lt->id . '\')" data-toggle="modal" data-target="#pembelian_modal" title="Edit">
                                <i class="fas fa-exclamation-triangle"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-circle delete" onclick="deleteData(\'_datpem\',\'' . $lt->id . '\')" title="Delete">
                                <i class="fas fa-trash"></i>
                              </a>';
            $hasil_rupiah = "Rp" . number_format($lt->total_beli);

            $row = array();
            $row[] = $lt->nama_produk;
            $row[] = $lt->nama_satuan;
            $row[] = $lt->qty;
            $row[] = $hasil_rupiah;
            $row[] = $lt->tanggal_beli;
            $row[] = $button_action;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->serversideModel->count_all('_data_pembelian'),
            'recordsFiltered' => $this->serversideModel->count_filtered('_data_pembelian', $column_order, $column_search, $order),
            'data' => $data,
        );

        return json_encode($output);
    }
}
