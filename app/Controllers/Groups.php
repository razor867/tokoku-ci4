<?php

namespace App\Controllers;

use App\Models\GroupsModel;

class Groups extends BaseController
{
    protected $model_groups;
    protected $validation;

    public function __construct()
    {
        $this->model_groups = new GroupsModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data['title'] = 'Groups';
        $data['modaltitle'] = 'Add Groups';
        $data['groups_data'] = $this->model_groups->findAll();
        $data['validation'] = $this->validation;
        return view('groups/v_groups', $data);
    }

    public function add()
    {
        if (!$this->validate($this->validation->getRuleGroup('add_groups'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/groups')->withInput();
        }
        $postData = $this->request->getPost();
        $this->model_groups->save($postData);

        session()->setFlashdata('info', 'Groups berhasil ditambahkan');
        return redirect()->to('/groups');
    }

    public function edit()
    {
        if (!$this->validate($this->validation->getRuleGroup('edit_groups'))) {
            session()->setFlashdata('info', 'error_add');
            return redirect()->to('/groups')->withInput();
        }
        $postData = $this->request->getPost();
        $this->model_groups->update($postData['id_groups'], $postData);

        session()->setFlashdata('info', 'Groups berhasil dirubah');
        return redirect()->to('/groups');
    }

    public function get_data_edit()
    {
        $this->request->isAJAX() or exit();
        $data = $this->model_groups->find($this->request->getPost('id'));

        echo json_encode($data);
    }

    public function delete($id_groups)
    {
        $this->model_groups->delete($id_groups);
        session()->setFlashdata('info', 'Groups berhasil dihapus');
        return redirect()->to('/groups');
    }
}
