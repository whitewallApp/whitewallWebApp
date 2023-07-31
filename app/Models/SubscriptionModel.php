<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class SubscriptionModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "subscription";
    protected $allowedFields = ["subscriptionID", "productID", "status", "account_id", "customerID"];

    /**
     * Gets a column in the database by the brand_id
     *
     * @param string $column
     * @param int $brandId
     * @param array $filterBy
     * @param string $getBy
     * @return array | an array of assiative arrays of the column
     */
    public function getCollumn($column, $brandId, $filterBy = [], $getBy = "account_id"): mixed
    {
        $builder = $this->db->table('subscription');
        $builder->select($column)->where($getBy, $brandId);

        if (count($filterBy) > 0) {
            $keys = array_keys($filterBy);
            foreach ($keys as $key) {
                $builder->where($key, $filterBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach ($return as $thing) {
            array_push($returnArray, $thing);
        }

        return $returnArray;
    }

    /**
     * Gets the subscription row
     *
     * @param  mixed $id The value you want to get the row by
     * @param  mixed $fetchBy The column you want it to search for the $id in
     * @param  mixed $filter An array of values you want it to return from 
     * @param  mixed $assoc If you want the return array to be an associate array or not
     * @return array
     */
    public function getSubscription($id, $fetchBy = "id", $filter = [], $assoc = false): mixed
    {
        $builder = $this->db->table('subscription');
        if (count($filter) > 0) {
            $builder->select($filter)->where($fetchBy, $id);
            $image = $builder->get()->getResultArray()[0];

            if (!$assoc) {
                if (count($filter) > 1) {
                    $array = [];

                    foreach ($filter as $thing) {
                        array_push($array, $image[$thing]);
                    }

                    return $array;
                } else {
                    if (count($filter) == 1) {
                        return $image[$filter[0]];
                    } else {
                        return $image;
                    }
                }
            } else {
                return $image;
            }
        } else {
            $builder->select("*")->where($fetchBy, $id);
            $imgID = $builder->get()->getResultArray();
            return $imgID;
        }
    }

    /**
     * Gets the Limit for the user
     *
     * @param integer $userID
     * @param string $limitName
     * @return integer
     */
    public function getLimit(int $userID, string $limitName): int {
        $userModel = new UserModel();
        $accountID = $userModel->getUser($userID, filter: ["account_id"]);
        $productID = $this->getSubscription($accountID, "account_id", ["productID"]);

        $builder = $this->db->table("products");
        $builder->select($limitName)->where("productID", $productID);
        $limit = $builder->get()->getResultArray()[0][$limitName];

        return (int)$limit;
    }

    /**
     * Checks if the account has used up all of its images
     *
     * @param integer $userID
     * @param integer $imageLimit
     * @return boolean reuturns true if they have it the limit
     */
    public function checkImageLimit(int $userID, int $imageLimit): bool{
        $brandModel = new BrandModel();
        $imageModel = new ImageModel();

        if ($imageLimit == 0){
            return false;
        }

        $brandids = $brandModel->getCollumn("id", $userID);

        $imageCount = 0;
        foreach ($brandids as $brandid) {
            $imageCount+= count($imageModel->getAllIds($brandid));
        }
        return $imageCount >= $imageLimit;
    }

    public function getCurrentImageCount($userID){
        $brandModel = new BrandModel();
        $imageModel = new ImageModel();
        $brandids = $brandModel->getCollumn("id", $userID);

        $imageCount = 0;
        foreach ($brandids as $brandid) {
            $imageCount += count($imageModel->getAllIds($brandid));
        }

        return $imageCount;
    }

    /**
     * Checks if the account has used up all of its users
     *
     * @param integer $userID
     * @param integer $userLimit
     * @return boolean reuturns true if they have it the limit
     */
    public function checkUserLimit(int $userID, int $userLimit): bool
    {
        $brandModel = new BrandModel();
        $userModel = new UserModel();

        if ($userLimit == 0){
            return false;
        }

        $brandids = $brandModel->getCollumn("id", $userID);

        $userCount = 0;
        foreach ($brandids as $brandid) {
            $userCount += count($userModel->getCollumn("id", $brandid));
        }
        return $userCount >= $userLimit;
    }

    public function getCurrentUserCount($userID){
        $brandModel = new BrandModel();
        $userModel = new UserModel();

        $brandids = $brandModel->getCollumn("id", $userID);

        $userCount = 0;
        foreach ($brandids as $brandid) {
            $userCount += count($userModel->getCollumn("id", $brandid));
        }

        return $userCount;
    }

    /**
     * Checks if the account has used up all of its brands
     *
     * @param integer $userID
     * @param integer $brandLimit
     * @return boolean reuturns true if they have it the limit
     */
    public function checkBrandLimit(int $userID, int $brandLimit): bool
    {
        $brandModel = new BrandModel();

        if ($brandLimit == 0){
            return false;
        }

        $brandids = $brandModel->getCollumn("id", $userID);
        
        
        return count($brandids) >= $brandLimit;
    }

    public function getCurrrentBrandCount($userID){
        $brandModel = new BrandModel();
        $brandids = $brandModel->getCollumn("id", $userID);
        return count($brandids);
    }

    /**
     * BROKEN!!!
     *
     * @param integer $userID
     * @param integer $imageLimit
     * @return boolean reuturns true if they have it the limit
     */
    public function checkAppLimit(int $userID, int $imageLimit): bool
    {
        return true;
    }
}
