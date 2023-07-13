<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\AppModel;
use Spatie\Async\Pool;

use function PHPSTORM_META\map;

class App extends BaseController

{
    private $appPath = "D:\whitewallApp";
    private $appSize = 2454788575;

    public function index()
    {

        return Navigation::renderNavBar("Versions",  "builds") . view('App') . Navigation::renderFooter();
    }

    public function compile($os){
        if ($os == "android" || $os == "ios"){
            $appModel = new AppModel();
            $session = session();
            $brand_id = $session->get("brand_id");
            $appModel->updateByMultipule(["brand_id" => $brand_id, "os" => $os], ["progress" => 0, "state" => "Copying Files..."]);
            session_write_close();
            set_time_limit(0);
            helper("filesystem");

            //if there isn't a directory make one else set progress to 100
            if (!is_dir("D:/" . $brand_id . "App")){
                directory_mirror($this->appPath, "D:/" . $brand_id . "App");
            }else{
                $appModel->updateByMultipule(["brand_id" => $brand_id, "os" => $os], ["progress" => 100, "state" => "Done"]);
            }
        }else{
            throw new \RuntimeException("Not a compatable OS");
        }
    }

    public function progress($os)
    {
        if ($os == "android" || $os == "ios") {
            $appModel = new AppModel();
            $session = session();
            $brand_id = $session->get("brand_id");
            session_write_close();
            helper("filesystem");

            //if they have an app already
            if (is_dir("D:/" . $brand_id . "App")){
                $size = (int)$this->folderSize("D:/" . $brand_id . "App");
                $progress = intval(($size / $this->appSize) * 100);
                $appModel->updateByMultipule(["brand_id" => $brand_id, "os" => $os], ["progress" => $progress]);
            }else{
                $progress = 0;
            }

            echo json_encode($appModel->where("brand_id", $brand_id)->select(["progress", "state"])->get()->getResultArray()[0]);
        }else{
            throw new \RuntimeException("Not a compatable OS");
        }
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