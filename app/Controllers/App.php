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

    public function compile($os)
    {
        if ($os == "android" || $os == "ios") {
            //get all session data before I close the session
            $appModel = new AppModel();
            $brandModel = new BrandModel();
            $session = session();
            $brand_id = $session->get("brand_id");
            $accountID = $brandModel->getBrand($brand_id, filter: ["account_id"]);

            //set up app paths
            $brandingPath = getenv("BASE_PATH") . $accountID . "/" . $brand_id . "/branding/";
            $copyAppPath = $brandingPath . "whitewallApp"; //set up app paths
            $appName = "Whitewall";

            //make it so I dont' get session locked
            session_write_close();
            set_time_limit(0);

            //set the last used app to not be the current version
            $appModel->updateByMultipule(["brand_id" => $brand_id, "current" => 1], ["current" => 0]);
            $rowID = null;
            try {
                $rowID = $appModel->selectByMultipule(["id"], ["brand_id" => $brand_id, "os" => $os])["id"];
            }catch(\Throwable $e){
                $rowID = $appModel->insert(["brand_id" => $brand_id, "os" => $os, "state" => "Copying Files...", "progress" => 0, "current" => true]);
            }


            $appName = json_decode((string)$brandModel->getBrand($brand_id, filter: ["branding"]), true)["appName"];

            $output = null;
            $retVal = null;

            $images = $brandModel->getBrand($brand_id, filter: ["appLoading", "appHeading", "appIcon"], assoc: true);
            $imageLoading = "";
            $imageHeading = "";
            $imageIcon = "";
            try {
                $imageLoading = explode("/", $images["appLoading"])[4];
                $imageHeading = explode("/", $images["appHeading"])[4];
                $imageIcon = explode("/", $images["appHeading"])[4];
            } catch (\Throwable $e) {
            }

            //variables for command line
            $descriptorspec = array(
                0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                2 => array("file", "/tmp/" . $brand_id . "-error.txt", "a") // stderr is a file to write to
            );

            //clone the repo
            $process = proc_open('git clone https://github.com/yomas000/whitewallApp.git', $descriptorspec, $pipes, $brandingPath, $_ENV);

            if (is_resource($process)) {

                echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // $appModel->update($rowID, ["state" => stream_get_line($pipes[1], 255)]);
                fclose($pipes[1]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            if (file_exists($brandingPath . "my-upload-key.keystore")) {
                copy($brandingPath . "my-upload-key.keystore", $copyAppPath . "/android/app/my-upload-key.keystore");

                $file = file_get_contents($copyAppPath . "/android/gradle.properties");
                file_put_contents($copyAppPath . "/android/gradle.properties", preg_replace("/\*\*\*\*\*/", "129034", $file));
            } else {
                //generate the key
                $process = proc_open('keytool -genkeypair -v -storetype PKCS12 -keystore my-upload-key.keystore -alias my-key-alias -keyalg RSA -keysize 2048 -validity 10000', $descriptorspec, $pipes, $brandingPath, $_ENV);

                if (is_resource($process)) {
                    $appModel->update($rowID, ["password" => "129034"]);

                    fwrite($pipes[0], "129034\n");
                    fwrite($pipes[0], "129034\n");

                    fwrite($pipes[0], "Johnathan Dick\n");
                    fwrite($pipes[0], "IT\n");
                    fwrite($pipes[0], "Whitewall\n");
                    fwrite($pipes[0], "Salt Lake City\n");
                    fwrite($pipes[0], "Utah\n");
                    fwrite($pipes[0], "US\n");
                    fwrite($pipes[0], "YES\n");

                    // It is important that you close any pipes before calling
                    // proc_close in order to avoid a deadlock
                    //fclose($pipes[1]);
                    fclose($pipes[0]);
                    $return_value = proc_close($process);

                    copy($brandingPath . "my-upload-key.keystore", $copyAppPath . "/android/app/my-upload-key.keystore");

                    $file = file_get_contents($copyAppPath . "/android/gradle.properties");
                    file_put_contents($copyAppPath . "/android/gradle.properties", preg_replace("/\*\*\*\*\*/", "129034", $file));
                }
            }

            $appModel->update($rowID, ["state" => "Installing...", "progress" => 30]);
            // install dependancies
            $process = proc_open('npm install', $descriptorspec, $pipes, $copyAppPath, $_ENV);

            if (is_resource($process)) {

                echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // $appModel->update($rowID, ["state" => stream_get_line($pipes[1], 255)]);
                fclose($pipes[1]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            $appModel->update($rowID, ["state" => "Styling...", "progress" => 40]);
            // load in app Icon
            if (file_exists($brandingPath . $imageIcon)){
                $process = proc_open('react-native set-icon --path  ../' . $imageIcon, $descriptorspec, $pipes, $copyAppPath, $_ENV);

                if (is_resource($process)) {

                    fwrite($pipes[0], '\n');
                    fclose($pipes[0]);

                    echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                    // $appModel->update($rowID, ["state" => stream_get_line($pipes[1], 255)]);
                    fclose($pipes[1]);

                    // It is important that you close any pipes before calling
                    // proc_close in order to avoid a deadlock
                    $return_value = proc_close($process);
                }
            }


            $appModel->update($rowID, ["state" => "Styling...", "progress" => 50]);
            //add header and loading images
            mkdir($copyAppPath . "/Icons");
            if (file_exists($brandingPath . $imageLoading)){
                copy($brandingPath . $imageLoading, $copyAppPath . "/Icons/" . $imageLoading);
                $file = file_get_contents($copyAppPath . "/App.tsx");
                file_put_contents( $copyAppPath . "/App.tsx", preg_replace("/appLoading.gif/", $imageLoading, $file));
            }

            if (file_exists($brandingPath . $imageHeading)) {
                copy($brandingPath . $imageHeading, $copyAppPath . "/Icons/" . $imageHeading);
                $file = file_get_contents($copyAppPath . "/Category.tsx");
                file_put_contents($copyAppPath . "/Category.tsx", preg_replace("/appHeading.jpeg/", $imageHeading, $file));
            }

            $appModel->update($rowID, ["state" => "Styling...", "progress" => 70]);
            //change the app name
            $iosFile = file_get_contents($copyAppPath . "/ios/whitewallApp/Info.plist");
            file_put_contents($copyAppPath . "/ios/whitewallApp/Info.plist", preg_replace("/whitewallApp/", $appName, $iosFile));

            $androidFile = file_get_contents($copyAppPath . "/android/app/src/main/res/values/strings.xml");
            file_put_contents($copyAppPath . "/android/app/src/main/res/values/strings.xml", preg_replace("/whitewallApp/", $appName, $androidFile));

            $appModel->update($rowID, ["state" => "Styling...", "progress" => 70]);
            //add the apikey
            $apikey = $brandModel->getBrand($brand_id, filter: ["apikey"]);
            $catFile = file_get_contents($copyAppPath . "/Category.tsx");
            file_put_contents($copyAppPath . "/Category.tsx", preg_replace("/\?apikey=.*(?=\")/", "?apikey=" . $apikey, $catFile));
            $appFile = file_get_contents($copyAppPath . "/App.tsx");
            file_put_contents($copyAppPath . "/App.tsx", preg_replace("/\?apikey=.*(?=\")/", "?apikey=" . $apikey, $appFile));

            // compile the app
            // $process = proc_open('gradlew assemble', $descriptorspec, $pipes, $copyAppPath . "/android", $_ENV);

            // if (is_resource($process)) {
            //     echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
            //     // $appModel->update($rowID, ["state" => stream_get_line($pipes[1], 255)]);
            //     fclose($pipes[1]);

            //     // It is important that you close any pipes before calling
            //     // proc_close in order to avoid a deadlock
            //     $return_value = proc_close($process);
            // }
        } else {
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
