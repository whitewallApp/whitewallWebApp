<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\AppModel;
use App\Models\SubscriptionModel;
use App\Models\VariablesModel;
use Google\Service\AndroidPublisher\Subscription;
use Google\Service\PagespeedInsights\RuntimeError;
use RuntimeException;

class App extends BaseController

{

    public function index()
    {   
        $brandModel = new BrandModel();
        $appModel = new AppModel();
        $subModel = new SubscriptionModel();
        $session = session();
        $accountId = $brandModel->getBrand($session->get("brand_id"), filter: ["account_id"]);
        $brandId = $session->get("brand_id");
        $brandPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/branding/";

        try {
            $date = date_format(date_create($appModel->selectByMultipule(["dateUpdated"], ["current" => true, "brand_id" => $brandId])["dateUpdated"]), "Y/m/d h:i:s A");
            $versionName = $appModel->selectByMultipule(["versionName"], ["current" => true, "brand_id" => $brandId])["versionName"];
        }catch(\Throwable $e){
            $date = "Why Not Today";
            $versionName = "Workspace";
        }

        $data = [
            "apkExists" => file_exists($brandPath . "app-release.apk"),
            "aabExists" => file_exists($brandPath . "app-release.aab"),
            "updatedDate" => $date,
            "name" => $versionName,
            "subStatus" => $subModel->getSubscription($accountId, "account_id", ["status"]),
            "admin" => $session->get("is_admin")
        ];

        return Navigation::renderNavBar("Versions",  "builds") . view('App', $data) . Navigation::renderFooter();
    }

    public function compile($os)
    {
        if ($os == "android" || $os == "ios") {
            //get all session data before I close the session
            $appModel = new AppModel();
            $brandModel = new BrandModel();
            $assets = new Assets();
            $session = session();
            $brand_id = $session->get("brand_id");
            $accountID = $brandModel->getBrand($brand_id, filter: ["account_id"]);
            $versionName = $this->request->getPost("version", FILTER_SANITIZE_SPECIAL_CHARS);

            // Set up the github workflow dispatch
            $owner = 'WhitewallApp'; 
            $repo = 'whitewallAppV2'; 
            $workflow_id = 'build.yml'; 
            $github_token = getenv('GITHUB_ACCESS'); 

            $ref = 'master'; 
            $inputs = [
                'style_file' => 'Stylesheet.tsx', // Example input, adjust as per your workflow
                'custom_config' => 'config.json',
                'output_file' => $accountID . "/" . $brand_id
            ];

            $url = "https://api.github.com/repos/{$owner}/{$repo}/actions/workflows/{$workflow_id}/dispatches";

            $headers = [
                "Authorization: token {$github_token}",
                "Accept: application/vnd.github.v3+json",
                "Content-Type: application/json",
                "User-Agent: Thomas"
            ];

            $payload = json_encode([
                'ref' => $ref,
                'inputs' => $inputs
            ]);

            if ($versionName === null){
                $versionName = "1.0";
            }

            // $subModel = new SubscriptionModel();
            // if ($subModel->getSubscription($accountID, "account_id", ["status"]) != "active"){
            //     throw new RuntimeException("You need to pay before using this service");
            // }

            // Set up all the files and config
            $assets->setupSharedFiles();
            //create config json
            $config = [
                "base_url" => "http://192.168.86.50",
                "api_base" => "/requests/v1",
                "api_key" => $brandModel->find($brand_id)["apikey"]
            ];
            $assets->saveConfigFile(json_encode($config), "config.json");

            $branding = json_decode($brandModel->find($brand_id)["branding"], true);
            $stylesheet = view("Config/Stylesheet", $branding);
            $assets->saveConfigFile($stylesheet, "Stylesheet.tsx");

            //Run the dispatch request
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            if ($http_code === 204) {
                echo "Workflow dispatch event successfully triggered.";
            } else {
                echo "Error triggering workflow dispatch event. HTTP Code: {$http_code}\n";
                echo "Response: {$response}\n";
            }

        }
    }

    public function progress($os)
    {
        if ($os == "android" || $os == "ios") {
            $appModel = new AppModel();
            $brandModel = new BrandModel();
            $session = session();
            $brand_id = $session->get("brand_id");
            $accountID = $brandModel->getBrand($brand_id, filter: ["account_id"]);
            session_write_close();

            echo json_encode($appModel->where("brand_id", $brand_id)->where("current", 1)->where("os", $os)->select(["progress", "state"])->get()->getResultArray()[0]);
        } else {
            throw new \RuntimeException("Not a compatable OS");
        }
    }

    function map($value, $fromLow, $fromHigh, $toLow, $toHigh)
    {
        $fromRange = $fromHigh - $fromLow;
        $toRange = $toHigh - $toLow;
        $scaleFactor = $toRange / $fromRange;

        // Re-zero the value within the from range
        $tmpValue = $value - $fromLow;
        // Rescale the value to the to range
        $tmpValue *= $scaleFactor;
        // Re-zero back to the to range
        return $tmpValue + $toLow;
    }

    function folderSize($dir)
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

    function sizeFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return round($bytes / $kb, 2) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return round($bytes / $mb, 2) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return round($bytes / $gb, 2) . ' GB';
        } elseif ($bytes >= $tb) {
            return round($bytes / $tb, 2) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}
