<?php

namespace App\Controllers;

use App\Models\PermissionsModel;

class Permissions extends BaseController
{
    protected $model_permissions;
    protected $validation;
    protected $perm;
    protected $permAdd;
    protected $permEdit;
    protected $permDelete;

    public function __construct()
    {
        $this->model_permissions = new PermissionsModel();
        $this->validation = \Config\Services::validation();
        $this->perm =  has_permission('halpermis/page');
        $this->permAdd = has_permission('halpermis/add');
        $this->permEdit = has_permission('halpermis/edit');
        $this->permDelete = has_permission('halpermis/delete');
    }

    public function index()
    {
        $this->perm or exit();

        $data['title'] = 'Permissions';
        $data['modaltitle'] = 'Add Permission';
        $data['permissions_data'] = $this->model_permissions->findAll();
        $data['validation'] = $this->validation;
        return view('permissions/v_permissions', $data);
    }

    public function add()
    {
        $this->permAdd or exit();

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
        $this->permEdit or exit();

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
        $this->permDelete or exit();

        $this->model_permissions->delete($id_permissions);
        session()->setFlashdata('info', 'Permission berhasil dihapus');
        return redirect()->to('/permissions');
    }
}
