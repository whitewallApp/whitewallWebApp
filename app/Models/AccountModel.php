<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "account";
    protected $allowedFields = ["id"];
}
