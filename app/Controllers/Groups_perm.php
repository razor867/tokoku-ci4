<?php

namespace App\Controllers;

use App\Models\GroupsModel;
use App\Models\GroupsPermModel;
use App\Models\PermissionsModel;

class Groups_perm extends BaseController
{
    protected $model_groups;
    protected $validation;
    protected $model_permission;
    protected $model_groups_perm;
    protected $perm;
    protected $permEdit;

    public function __construct()
    {
        $this->model_groups = new GroupsModel();
        $this->validation = \Config\Services::validation();
        $this->model_permission = new PermissionsModel();
        $this->model_groups_perm = new GroupsPermModel();
        $this->perm = has_permission('groups_perm/page');
        $this->permEdit = has_permission('groups_perm/setting');
    }

    public function index()
    {
        $this->perm or exit();

        $data['title'] = 'Groups Permissions';
        $data['modaltitle'] = 'Setting Group Permission';
        $data['groups_data'] = $this->model_groups->findAll();
        $data['validation'] = $this->validation;
        return view('groups/v_groups_permissions', $data);
    }

    public function get_listperm()
    {
        $this->request->isAJAX() or exit();

        $group_id = $this->request->getPost('id');
        $permission = $this->model_permission->orderBy('name', 'ASC')->findAll();

        $iter = 0;
        foreach ($permission as $p) {
            $check_perm = $this->model_groups_perm->where(['group_id' => $group_id, 'permission_id' => $p->id])->findAll();
            if ($check_perm) {
                $list_permission[] = '<div class="custom-control custom-checkbox">
                <input type="checkbox" name="perm[]" value="' . $p->id . '" class="custom-control-input" id="perm' . $iter . '" checked>
                <label class="custom-control-label perm" for="perm' . $iter . '">' . $p->name . '</label>
                </div>';
            } else {
                $list_permission[] = '<div class="custom-control custom-checkbox">
                <input type="checkbox" name="perm[]" value="' . $p->id . '" class="custom-control-input" id="perm' . $iter . '">
                <label class="custom-control-label perm" for="perm' . $iter . '">' . $p->name . '</label>
                </div>';
            }
            $iter++;
        }
        echo json_encode($list_permission);
    }

    public function edit()
    {
        $this->permEdit or exit();

        $group_id = $this->request->getPost('id_groups');
        $perms = $this->request->getPost('perm');

        if (is_array($perms)) {
            $group_perm_list = $this->model_groups_perm->where(['group_id' => $group_id])->findAll();
            foreach ($perms as $p) {
                $check_perm = $this->model_groups_perm->where(['group_id' => $group_id, 'permission_id' => $p])->findAll();
                if ($check_perm) {
                    $this->model_groups_perm->update($check_perm[0]->id, ['group_id' => $group_id, 'permission_id' => $p]);
                } else {
                    $this->model_groups_perm->save(['group_id' => $group_id, 'permission_id' => $p]);
                }
            }

            if ($group_perm_list) {
                foreach ($group_perm_list as $gpl) {
                    if (!in_array($gpl->permission_id, $perms)) {
                        $this->model_groups_perm->delete($gpl->id);
                    }
                }
            }
        } else {
            $group_perm_list = $this->model_groups_perm->where(['group_id' => $group_id])->findAll();
            if ($group_perm_list) {
                foreach ($group_perm_list as $gpl) {
                    $this->model_groups_perm->delete($gpl->id);
                }
            }
        }

        session()->setFlashdata('info', 'Setelan group permission berhasil disimpan');
        return redirect()->to('/groups_perm');
    }
}
