<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

class AppModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "app";
    protected $allowedFields = ["brand_id", "appName", "versionName", "os", "state", "progress", "current", "signingKey", "password"];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'publishedDate';
    protected $updatedField  = 'dateUpdated';


    public function updateBy($id, $data, $updateBy = "id")
    {
        $builder = $this->db->table("app");
        $builder->where($updateBy, $id);
        $builder->update($data);
    }

    public function updateByMultipule($ids, $data)
    {
        $builder = $this->db->table("app");
        foreach ($ids as $key => $value) {
            $builder->where($key, $value);
        }
        $builder->update($data);
    }
}
