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

    /**
     * This will update a row by something other than the primary id | primary id is default
     *
     * @param string $id | id
     * @param array $data | data to update, is assoc
     * @param string $updateBy | column to search for $id
     * @return void
     */
    public function updateBy($id, $data, $updateBy = "id")
    {
        $builder = $this->db->table("app");
        $builder->where($updateBy, $id);
        $builder->update($data);
    }
    
    /**
     * Updates a row by multipul ids
     *
     * @param array $ids | assoc. array of ids 
     * @param array $data | assoc. array of data
     * @return void
     */
    public function updateByMultipule($ids, $data)
    {
        $builder = $this->db->table("app");
        foreach ($ids as $key => $value) {
            $builder->where($key, $value);
        }
        $builder->update($data);
    }

    /**
     * Selects columns of a row by multipule ids
     *
     * @param array|string $selections | the columns you want to get
     * @param array $ids | assoc. array of ids
     * @return array
     */
    public function selectByMultipule($selections, $ids)
    {
        $builder = $this->db->table("app");
        foreach ($ids as $key => $value) {
            $builder->where($key, $value);
        }
        return $builder->select($selections)->get()->getResultArray()[0];
    }
}
