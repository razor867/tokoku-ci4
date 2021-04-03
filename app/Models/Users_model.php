<?php

namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model
{
    protected $table = 'users';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'firstname', 'lastname', 'profile_picture'
    ];

    protected $useTimestamps = true;

    public function getroles($group_id = '')
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('auth_groups');
        if ($group_id) {
            return $builder->where('id', $group_id)->get()->getResult();
        } else {
            return $builder->get()->getResult();
        }
    }

    public function getUserGroup($id_user)
    {
        $builder = $this->builder();
        return $builder->from('auth_groups_users')->where('user_id', $id_user)->get()->getResult();
    }

    public function addUserToGroup($id_user, $id_group)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('auth_groups_users');
        $data = [
            'group_id' => $id_group,
            'user_id' => $id_user
        ];
        $builder->insert($data);
    }

    public function getRoleNameById($id_user)
    {
        $group_id = '';
        $data_group = $this->getUserGroup($id_user);
        foreach ($data_group as $d) {
            $group_id = $d->group_id;
        }
        $data = $this->getroles($group_id);
        foreach ($data as $d) {
            return $d->name;
        }
    }

    public function edit_user($id_user, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id_user);
        $builder->update($data);
    }
}
