<?php

namespace App\Controllers;

use App\Models\KategoriProdukModel;
use App\Models\Serverside_model;

class Kategori_produk extends BaseController
{
    protected $m_cat_produk;
    protected $validation;
    protected $serversideModel;
    protected $perm;
    protected $permAdd;
    protected $permEdit;
    protected $permDelete;

    public function __construct()
    {
        $this->m_cat_produk = new KategoriProdukModel();
        $this->validation = \Config\Services::validation();
        $this->serversideModel = new Serverside_model();
        $this->perm =  has_permission('kategori_produk/page');
        $this->permAdd = has_permission('kategori_produk/add');
        $this->permEdit = has_permission('kategori_produk/edit');
        $this->permDelete = has_permission('kategori_produk/delete');
    }

    public function index()
    {
        $this->perm or exit();

        $data['title'] = 'Kategori Produk';
        $data['validation'] = $this->validation;
        return view('/kategori_produk/v_kategori_produk', $data);
    }

    public function addKategori()
    {
        $this->permAdd or exit();

        if (!$this->validate($this->validation->getRuleGroup('kategori'))) {
            session()->setFlashdata('info', 'error_add');
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
        $this->request->isAJAX() or exit();

        $id = $this->request->getpost('id');
        $query = $this->m_cat_produk->find($id);
        echo json_encode($query);
    }

    public function editKategori()
    {
        $this->permEdit or exit();

        if (!$this->validate($this->validation->getRuleGroup('kategori'))) {
            session()->setFlashdata('info', 'error_edit');
            return redirect()->to('/kategori_produk')->withInput();
        }
        $id = $this->request->getPost('id');
        $category = $this->request->getPost('kategori');
        $deskripsi = $this->request->getPost('deskripsi');

        $query = $this->m_cat_produk->find($id);
        if ($query) {
            $this->m_cat_produk->update($id, [
                'nama_category' => $category,
                'deskripsi' => $deskripsi
            ]);
            session()->setFlashdata('info', 'Data berhasil dirubah');
        } else {
            session()->setFlashdata('info', 'error_edit');
        }

        return redirect()->to('/kategori_produk');
    }

    public function deleteKategori($id)
    {
        $this->permDelete or exit();

        if (!preg_match('/^[0-9]*$/', $id)) {
            session()->setFlashdata('info', 'error_delete');
            return redirect()->to('/kategori_produk');
        }
        $query = $this->m_cat_produk->find($id);
        if ($query) {
            $this->m_cat_produk->delete($id);
            session()->setFlashdata('info', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('info', 'error_delete');
        }

        return redirect()->to('/kategori_produk');
    }

    public function listdata()
    {
        if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Gudang')) {
            $column_order = array('nama_category', 'deskripsi', 'id');
        } else {
            $column_order = array('nama_category', 'deskripsi');
        }

        $column_search = array('nama_category', 'deskripsi');
        $order = array('nama_category' => 'asc');
        $list = $this->serversideModel->get_datatables('cat_produk', $column_order, $column_search, $order);
        $data = array();
        // $no = $this->request->getPost('start');
        foreach ($list as $lt) {
            if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Gudang')) {
                $button_action = '<a href="#" class="btn btn-warning btn-circle edit" onclick="edit(\'' . $lt->id . '\')" data-toggle="modal" data-target="#kategori_produk_modal" title="Edit">
                                <i class="fas fa-exclamation-triangle"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-circle delete" onclick="deleteData(\'_cat_product\',\'' . $lt->id . '\')" title="Delete">
                                <i class="fas fa-trash"></i>
                              </a>';
            }

            $row = array();
            $row[] = $lt->nama_category;
            $row[] = $lt->deskripsi;
            if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Gudang')) {
                $row[] = $button_action;
            }
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->serversideModel->count_all('cat_produk'),
            'recordsFiltered' => $this->serversideModel->count_filtered('cat_produk', $column_order, $column_search, $order),
            'data' => $data,
        );

        return json_encode($output);
    }
}
