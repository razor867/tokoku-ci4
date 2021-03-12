<?php

namespace App\Controllers;

use App\Models\SatuanModel;
use App\Models\Serverside_model;

class Satuan extends BaseController
{
    protected $m_satuan;
    protected $serversideModel;

    public function __construct()
    {
        $this->m_satuan = new SatuanModel();
        $this->serversideModel = new Serverside_model();
    }

    public function index()
    {
        $data['title'] = 'Satuan Produk';
        $data['validation'] = \Config\Services::validation();
        return view('satuan/v_satuan_produk', $data);
    }

    public function addSatuan()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate($validation->getRuleGroup('satuan'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/satuan')->withInput();
        }
        $satuan = $this->request->getPost('satuan');
        $deskripsi = $this->request->getPost('deskripsi');
        $this->m_satuan->save([
            'nama_satuan' => $satuan,
            'deskripsi' => $deskripsi
        ]);
        session()->setFlashdata('info', 'Data berhasil disimpan');
        return redirect()->to('/satuan');
    }

    public function getRowSatuan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getpost('id');
            $query = $this->m_satuan->find($id);
            echo json_encode($query);
        } else {
            return redirect()->to('/satuan');
        }
    }

    public function editSatuan()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate($validation->getRuleGroup('satuan'))) {
            session()->setFlashdata('info', 'error_edit');
            return redirect()->to('/satuan')->withInput();
        }
        $id = $this->request->getPost('id');
        $satuan = $this->request->getPost('satuan');
        $deskripsi = $this->request->getPost('deskripsi');

        $query = $this->m_satuan->find($id);
        if ($query) {
            $this->m_satuan->update($id, [
                'nama_satuan' => $satuan,
                'deskripsi' => $deskripsi
            ]);
            session()->setFlashdata('info', 'Data berhasil di edit');
        } else {
            session()->setFlashdata('info', 'error_edit');
        }

        return redirect()->to('/satuan');
    }

    public function deleteSatuan($id)
    {
        if (!preg_match('/^[0-9]*$/', $id)) {
            session()->setFlashdata('info', 'error_delete');
            return redirect()->to('/satuan');
        }
        $query = $this->m_satuan->find($id);
        if ($query) {
            $this->m_satuan->delete($id);
            session()->setFlashdata('info', 'Data berhasil di hapus');
        } else {
            session()->setFlashdata('info', 'error_delete');
        }

        return redirect()->to('/satuan');
    }

    public function listdata()
    {
        $column_order = array('nama_satuan', 'deskripsi', 'id');
        $column_search = array('nama_satuan', 'deskripsi');
        $order = array('nama_satuan' => 'asc');
        $list = $this->serversideModel->get_datatables('satuan_produk', $column_order, $column_search, $order);
        $data = array();
        // $no = $this->request->getPost('start');
        foreach ($list as $lt) {
            $button_action = '<a href="#" class="btn btn-warning btn-circle edit" onclick="edit(\'' . $lt->id . '\')" data-toggle="modal" data-target="#satuan_modal" title="Edit">
                                <i class="fas fa-exclamation-triangle"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-circle delete" onclick="deleteData(\'_satpro\',\'' . $lt->id . '\')" title="Delete">
                                <i class="fas fa-trash"></i>
                              </a>';

            $row = array();
            $row[] = $lt->nama_satuan;
            $row[] = $lt->deskripsi;
            $row[] = $button_action;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->serversideModel->count_all('satuan_produk'),
            'recordsFiltered' => $this->serversideModel->count_filtered('satuan_produk', $column_order, $column_search, $order),
            'data' => $data,
        );

        return json_encode($output);
    }
}
