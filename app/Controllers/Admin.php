<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;
use App\Models\VariablesModel;

class Admin extends BaseController

{
    public function index()
    {
        $session = session();
        if ($session->get("super_admin") !== null){
            $accountModel = new AccountModel();
            $brandModel = new BrandModel();
            $imageModel = new ImageModel();
            $catModel = new CategoryModel();
            $colModel = new CollectionModel();
            $subModel = new SubscriptionModel();
            $userModel = new UserModel();
            $accountIds = $accountModel->findColumn("id");

            $data = [];

            foreach ($accountIds as $accountID) {
                $account = [
                    "account_id" => $accountID,
                    "brands" => []
                ];
                if ($subModel->getSubscription($accountID, "account_id", ["status"]) === null){
                    $account["subscription"] = "Trial";
                }else{
                    $account["subscription"] = $subModel->getSubscription($accountID, "account_id", ["status"]);
                }
                
                $brandIds = $brandModel->getCollumn("id", $accountID, fetchBy: "account_id");

                $brandIds = array_unique(array_column($brandIds, "id"));

                foreach ($brandIds as $brandID) {
                    $brand = [];

                    $brand["identity"] = $brandModel->getBrand($brandID, filter: ["name", "id"], assoc: true);
                    $brand["categories"] = count($catModel->getCollumn("id", $brandID));
                    $brand["collections"] = count($colModel->getCollumn("id", $brandID));
                    $brand["images"] = count($imageModel->getCollumn("id", $brandID));
                    $brand["users"] = count($userModel->getCollumn("id", $brandID));
                    $brand["wallpapers"] = array_sum(array_column($imageModel->getCollumn("wallpaperClick", $brandID), "wallpaperClick"));
                    $brand["links"] = array_sum(array_column($imageModel->getCollumn("linkClick", $brandID), "linkClick"));

                    array_push($account["brands"], $brand);
                }

                array_push($data, $account);
            }

            $chartData = [];
            $chartData["paying"] = [
                ["Status", "Account Amount"],
                ["Paying", count($subModel->where("status", "active")->get()->getResultArray())],
                ["Ended", count($subModel->where("status", "ended")->get()->getResultArray())],
                ["Trial", count($subModel->where("status", null)->get()->getResultArray())],
            ];

            $chartData["storage"] = [
                ["Type", "GiB"],
                ["Current Size: GiB", floatval($this->bytes(disk_total_space("/") - disk_free_space("/"), "GiB"))],
                ["Storage Left: GiB", floatval($this->bytes(disk_free_space("/"), "GiB"))],
            ];

            $varModel = new VariablesModel();

            $data = [
                "accounts" => $data, 
                "chartData" => $chartData,
                "variables" => $varModel->findAll()
            ];

            return Navigation::renderNavBar("Super Admin") . view("Admin", $data) . Navigation::renderFooter();
        }else{
            http_response_code(404);
            exit;
        }
    }

    public function getFolderSize(){
        $session = session();
        if ($session->get("super_admin") !== null) {
            helper("filesystem");
            $id = $this->request->getPost("id", FILTER_VALIDATE_INT);

            if ($id !== null){
                echo $this->bytes($this->folderSize(getenv("BASE_PATH") . $id));
            }
        }
    }

    public function variables(){
        $session = session();
        if ($session->get("super_admin") !== null) {
            $id = $this->request->getPost("id", FILTER_VALIDATE_INT);
            $val = $this->request->getPost("value", FILTER_SANITIZE_SPECIAL_CHARS);

            $varModel = new VariablesModel();
            $varModel->update($id, ["value" => $val]);
        }
    }

    private function folderSize($dir)
    {
        $count_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($dir . "/" . $filename)) {
                    $new_foldersize = $this->foldersize($dir . "/" . $filename);
                    $count_size = $count_size + $new_foldersize;
                } else if (is_file($dir . "/" . $filename)) {
                    $count_size = $count_size + filesize($dir . "/" . $filename);
                    $count++;
                }
            }
        }
        return $count_size;
    }

    private function bytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
    {
        // Format string
        $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

        // IEC prefixes (binary)
        if ($si == FALSE or strpos($force_unit, 'i') !== FALSE
        ) {
            $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
            $mod   = 1024;
        }
        // SI prefixes (decimal)
        else {
            $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
            $mod   = 1000;
        }

        // Determine unit to use
        if (($power = array_search((string) $force_unit, $units)) === FALSE) {
            $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
        }

        return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
    }
}