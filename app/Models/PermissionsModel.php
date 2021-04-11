<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionsModel extends Model
{
    protected $table = 'auth_permissions';
    protected $primarykey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = [
        'name', 'description',
    ];
}
