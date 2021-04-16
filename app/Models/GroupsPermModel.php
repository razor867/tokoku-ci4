<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsPermModel extends Model
{
    protected $table = 'auth_groups_permissions';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = [
        'group_id', 'permission_id',
    ];

    public function group_perm_bygroupid($group_id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('_permission');
        $builder->select('permission_id, permission_name');
        $builder->where('group_id', $group_id);
        $builder->orderBy('permission_name', 'ASC');
        return $builder->get()->getResult();
    }
}
