<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\AppModel;

class App extends BaseController

{

    public function index()
    {

        return Navigation::renderNavBar("Versions",  "builds") . view('App') . Navigation::renderFooter();
    }

    public function compile($os){
        if ($os == "android" || $os == "ios"){
            //get all session data before I close the session
            $appModel = new AppModel();
            $brandModel = new BrandModel();
            $session = session();
            $brand_id = $session->get("brand_id");
            $accountID = $brandModel->getBrand($brand_id, filter: ["account_id"]);

            //set up app paths
            $brandingPath = getenv("BASE_PATH") . $accountID . "/" . $brand_id . "/branding/";
            $copyAppPath = $brandingPath . "whitewallApp"; //set up app paths

            //make it so I dont' get session locked
            session_write_close();
            set_time_limit(0);

            //set the last used app to not be the current version
            // $appModel->updateByMultipule(["brand_id" => $brand_id, "current" => 1], ["current" => 0]);
            // $rowID = $appModel->insert(["brand_id" => $brand_id, "os" => $os, "state" => "Copying Files...", "progress" => 0, "current" => true]);

            $descriptorspec = array(
                0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
             );

            $output = null;
            $retVal = null;

            $process = null;
            //style the app
            if (PHP_OS == "Linux") {
                $process = proc_open('appStyle.sh ' . $copyAppPath . " " . $brandingPath, $descriptorspec, $pipes, "/srv/htp/whitewallWebApp/app/Controllers/App", $_ENV);
                echo "linux";
            }else{
                $process = proc_open('appStyle.bat ' . $copyAppPath . " " . $brandingPath, $descriptorspec, $pipes, "C:/wamp64/www/whitewall/app/Controllers/App", $_ENV);
            }
             
             if (is_resource($process)) {
                echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // echo var_dump(stream_get_contents($pipes[1]));
                fclose($pipes[1]);

                //echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // echo var_dump(stream_get_contents($pipes[1]));
                //fclose($pipes[2]);
            
                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
             }


            //compile the app

            // $process = proc_open('gradlew assemble', $descriptorspec, $pipes, $copyAppPath . "/android", $_ENV);

            // if (is_resource($process)) {
            //     echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
            //     // $appModel->update($rowID, ["state" => stream_get_line($pipes[1], 255)]);
            //     fclose($pipes[1]);

            //     echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
            //     // echo var_dump(stream_get_contents($pipes[1]));
            //     fclose($pipes[2]);

            //     // It is important that you close any pipes before calling
            //     // proc_close in order to avoid a deadlock
            //     $return_value = proc_close($process);
            // }
        }else{
            throw new \RuntimeException("Not a compatable OS");
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

            echo json_encode($appModel->where("brand_id", $brand_id)->where("current", 1)->select(["progress", "state"])->get()->getResultArray()[0]);
        }else{
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