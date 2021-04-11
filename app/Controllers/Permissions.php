<?php

namespace App\Controllers;

use App\Models\PermissionsModel;

class Permissions extends BaseController
{
    protected $model_permissions;
    protected $validation;

    public function __construct()
    {
        $this->model_permissions = new PermissionsModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['title'] = 'Permissions';
        $data['modaltitle'] = 'Add Permission';
        $data['permissions_data'] = $this->model_permissions->findAll();
        $data['validation'] = $this->validation;
        return view('permissions/v_permissions', $data);
    }

    public function add()
    {
        if (!$this->validate($this->validation->getRuleGroup('add_permissions'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/permissions')->withInput();
        }
        $postData = $this->request->getPost();
        $this->model_permissions->save($postData);

        session()->setFlashdata('info', 'Permissions berhasil ditambahkan');
        return redirect()->to('/permissions');
    }

    public function edit()
    {
        if (!$this->validate($this->validation->getRuleGroup('edit_permissions'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/permissions')->withInput();
        }
        $postData = $this->request->getPost();
        $this->model_permissions->update($postData['id_permissions'], $postData);

        session()->setFlashdata('info', 'Permissions berhasil dirubah');
        return redirect()->to('/permissions');
    }

    public function get_data_edit()
    {
        $this->request->isAJAX() or exit();
        $data = $this->model_permissions->find($this->request->getPost('id'));

        echo json_encode($data);
    }

    public function delete($id_permissions)
    {
        $this->model_permissions->delete($id_permissions);
        session()->setFlashdata('info', 'Permission berhasil dihapus');
        return redirect()->to('/permissions');
    }
}
