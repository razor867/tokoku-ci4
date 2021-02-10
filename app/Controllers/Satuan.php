<?php

namespace App\Controllers;

use App\Models\SatuanModel;

class Satuan extends BaseController
{
    protected $m_satuan;

    public function __construct()
    {
        $this->m_satuan = new SatuanModel();
    }

    public function index()
    {
        $data['title'] = 'Satuan Produk';
        $data['validation'] = \Config\Services::validation();
        $data['satuan'] = $this->m_satuan->findAll();
        return view('satuan/v_satuan_produk', $data);
    }

    public function addSatuan()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate($validation->getRuleGroup('satuan'))) {
            session()->setFlashdata('info', 'error');
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
            session()->setFlashdata('info', 'error');
            return redirect()->to('/satuan')->withInput();
        }
        $id = $this->request->getPost('id');
        $satuan = $this->request->getPost('satuan');
        $deskripsi = $this->request->getPost('deskripsi');
        $this->m_satuan->update($id, [
            'nama_satuan' => $satuan,
            'deskripsi' => $deskripsi
        ]);
        session()->setFlashdata('info', 'Data berhasil di edit');
        return redirect()->to('/satuan');
    }

    public function deleteSatuan($id)
    {
        if (!preg_match('/^[0-9]*$/', $id)) {
            session()->setFlashdata('info', 'error');
            return redirect()->to('/satuan');
        }
        $this->m_satuan->delete($id);
        session()->setFlashdata('info', 'Data berhasil di hapus');
        return redirect()->to('/satuan');
    }
}
