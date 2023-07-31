<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class CategoryModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "category";

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';
    protected $allowedFields = ["name", "description", "iconPath", "link", "brand_id"];
    
    /**
     * Get the column(s) in the Category table based on brand name.
     *
     * @param  array|string $column The column(s) that you want to get from the database
     * @param  string $brandName The brand name that the user belongs to
     * @param  array $getBy An array of key value pairs for further filtering. EX: ["category_used" => 1]
     * @return array | an array of the column
     */
    public function getCollumn(array|string $column, string $brandId, array $getBy=[]): mixed{

        $builder = $this->db->table('category');
        $builder->select($column)->where("brand_id", $brandId);

        if (count($getBy) > 0){
            $keys = array_keys($getBy);
            foreach ($keys as $key) {
                $builder->where($key, $getBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach($return as $thing){
            array_push($returnArray, $thing[$column]);
        }

        return $returnArray;
    }
    
    /**
     * getCategory
     *
     * @param  mixed $id The value you want to get the row by
     * @param  mixed $fetchBy The column you want it to search for the $id in
     * @param  mixed $filter An array of values you want it to return from 
     * @param  mixed $assoc If you want the return array to be an associate array or not
     * @return array
     */
    public function getCategory($id, $fetchBy="id", $filter=[], $assoc=false): mixed{
        $builder = $this->db->table('category');
        
        if (count($filter) > 0){
            $builder->select($filter)->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];

            if (!$assoc){
                if (count($filter) > 1){
                    $array = [];

                    foreach ($filter as $thing){
                        array_push($array, $collection[$thing]);
                    }

                    return $array;
                }else{
                    if (count($filter) == 1){
                        return $collection[$filter[0]];
                    }else{
                        return $collection;
                    }
                }
            }else{
                return $collection;
            }

        }else{
            $builder->select("*")->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];
            return $collection;
        }
    }

    public function updateCategory($id, $data, $updateBy = "id")
    {
        $data["dateUpdated"] = new RawSql('CURRENT_TIMESTAMP');

        $builder = $this->db->table("category");
        $builder->where($updateBy, $id);
        $builder->update($data);
    }

    public function like(string $column, array|string $query)
    {
        $builder = $this->db->table('category');
        return $builder->orLike($column, $query, insensitiveSearch: true)->get()->getResultArray();
    }
}