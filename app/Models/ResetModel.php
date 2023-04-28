<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "resetkeys";
    protected $allowedFields = ["user_id", "reset_key"];
}
