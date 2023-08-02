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
            "subStatus" => $subModel->getSubscription($accountId, "account_id", ["status"])
        ];

        return Navigation::renderNavBar("Versions",  "builds") . view('App', $data) . Navigation::renderFooter();
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
            $versionName = $this->request->getPost("version", FILTER_SANITIZE_SPECIAL_CHARS);

            if ($versionName === null){
                $versionName = "1.0";
            }

            $subModel = new SubscriptionModel();
            if ($subModel->getSubscription($accountID, "account_id", ["status"]) != "active"){
                throw new RuntimeException("You need to pay before using this service");
            }

            

            //set up app paths
            $brandingPath = getenv("BASE_PATH") . $accountID . "/" . $brand_id . "/branding/";
            $copyAppPath = $brandingPath . "whitewallApp"; //set up app paths
            $appName = "Whitewall";

            //make it so I dont' get session locked
            session_write_close();
            set_time_limit(0);

            //set the last used app to not be the current version
            // $appModel->updateByMultipule(["brand_id" => $brand_id, "current" => 1], ["current" => 0]);
            $rowID = null;
            try {
                $rowID = $appModel->selectByMultipule(["id"], ["brand_id" => $brand_id, "os" => $os])["id"];
                $appModel->update($rowID, ["versionName" => $versionName]);
            }catch(\Throwable $e){
                $rowID = $appModel->insert(["brand_id" => $brand_id, "os" => $os, "state" => "Copying Files...", "progress" => 0, "current" => true, "versionName" => $versionName]);
            }


            $appName = json_decode((string)$brandModel->getBrand($brand_id, filter: ["branding"]), true)["appName"];

            $output = null;
            $retVal = null;

            $images = $brandModel->getBrand($brand_id, filter: ["appLoading", "appHeading", "appIcon"], assoc: true);

            foreach ($images as $image) {
                if ($image == ""){
                    $appModel->update($rowID, ["state" => "Error: Not all Branding images set", "progress" => 0]);
                    throw new RuntimeError("Branding Error");
                }
            }


            $imageLoading = "";
            $imageHeading = "";
            $imageIcon = "";
            try {
                $imageLoading = explode("/", $images["appLoading"])[4];
                $imageHeading = explode("/", $images["appHeading"])[4];
                $imageIcon = explode("/", $images["appIcon"])[4];
            } catch (\Throwable $e) {
            }

            if (file_exists($brandingPath . "app-log.txt")){
                unlink($brandingPath . "app-log.txt");
            }

            //variables for command line
            $descriptorspec = array(
                0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                1 => array("file", $brandingPath . "app-log.txt", "a"),  // stdout is a pipe that the child will write to
                2 => array("file", $brandingPath . "app-log.txt", "a") // stderr is a file to write to
            );


            $appModel->update($rowID, ["state" => "Downloading...", "progress" => 10]);
            //clone the repo
            $process = proc_open('git clone https://github.com/yomas000/whitewallApp.git', $descriptorspec, $pipes, $brandingPath, $_ENV);

            if (is_resource($process)) {

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // fclose($pipes[1]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // fclose($pipes[2]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            if (file_exists($brandingPath . "my-upload-key.keystore")) {
                copy($brandingPath . "my-upload-key.keystore", $copyAppPath . "/android/app/my-upload-key.keystore");

                $file = file_get_contents($copyAppPath . "/android/gradle.properties");
                $password = $appModel->selectByMultipule("password", ["id" => $rowID])["password"];
                file_put_contents($copyAppPath . "/android/gradle.properties", preg_replace("/\*\*\*\*\*/", $password, $file));
            } else {
                $keystorepass = bin2hex(random_bytes(4));
                //generate the key
                $process = proc_open('keytool -genkeypair -v -storetype PKCS12 -keystore my-upload-key.keystore -alias my-key-alias -keyalg RSA -keysize 2048 -validity 10000', $descriptorspec, $pipes, $brandingPath, $_ENV);

                if (is_resource($process)) {
                    $appModel->update($rowID, ["password" => $keystorepass]);

                    fwrite($pipes[0], $keystorepass . "\n");
                    fwrite($pipes[0], $keystorepass . "\n");

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

                    // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                    // fclose($pipes[2]);

                    $return_value = proc_close($process);

                    copy($brandingPath . "my-upload-key.keystore", $copyAppPath . "/android/app/my-upload-key.keystore");

                    $file = file_get_contents($copyAppPath . "/android/gradle.properties");
                    file_put_contents($copyAppPath . "/android/gradle.properties", preg_replace("/\*\*\*\*\*/", $keystorepass, $file));
                }
            }

            $appModel->update($rowID, ["state" => "Installing...", "progress" => 30]);
            // install dependancies
            $process = proc_open('npm install', $descriptorspec, $pipes, $copyAppPath);

            if (is_resource($process)) {

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // fclose($pipes[1]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // fclose($pipes[2]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            $appModel->update($rowID, ["state" => "Styling...", "progress" => 45]);
            // load in app Icon
            if (file_exists($brandingPath . $imageIcon)){
                $process = proc_open('npx react-native set-icon --path  ../' . $imageIcon, $descriptorspec, $pipes, $copyAppPath);

                if (is_resource($process)) {

                    fwrite($pipes[0], '\n');
                    fclose($pipes[0]);

                    // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                    // fclose($pipes[1]);

                    // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                    // fclose($pipes[2]);

                    // It is important that you close any pipes before calling
                    // proc_close in order to avoid a deadlock
                    $return_value = proc_close($process);
                }
            }
            
            $file = file_get_contents($copyAppPath . "/Style.tsx");
            file_put_contents($copyAppPath . "/Style.tsx", view("brand/Style", ["branding" => json_decode((string)$brandModel->getBrand($brand_id, filter: ["branding"]), true)]));

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

            $appModel->update($rowID, ["state" => "Compiling... This could take up to 20 minutes (you may leave the page)", "progress" => 70]);

            //compile the app
            $env = $_ENV;
            $env["ANDROID_HOME"] = "/opt/android-sdk";
            $env["JAVA_HOME"] = "/usr/lib/jvm/java-11-openjdk";
            $process = proc_open('./gradlew assembleRelease', $descriptorspec, $pipes, $copyAppPath . "/android", $env);

            if (is_resource($process)) {

                // fwrite($pipes[0], "build");
                // fclose($pipes[0]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // fclose($pipes[1]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // fclose($pipes[2]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            $appModel->update($rowID, ["progress" => 75]);

            $process = proc_open('./gradlew bundleRelease', $descriptorspec, $pipes, $copyAppPath . "/android", $env);

            if (is_resource($process)) {

                // fwrite($pipes[0], "build");
                // fclose($pipes[0]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // fclose($pipes[1]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // fclose($pipes[2]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            $appModel->update($rowID, ["progress" => 85]);

            //remove previously compiled files if exist
            if (file_exists($brandingPath . "app-release.aab")) {
                unlink($brandingPath . "app-release.aab");
            }

            if (file_exists($brandingPath . "app-release.apk")) {
                unlink($brandingPath . "app-release.apk");
            }


            //copy compiled files
            if (file_exists($copyAppPath . "/android/app/build/outputs/bundle/release/app-release.aab")){
                copy($copyAppPath . "/android/app/build/outputs/bundle/release/app-release.aab", $brandingPath . "app-release.aab");
            }

            if (file_exists($copyAppPath . "/android/app/build/outputs/apk/release/app-release.apk")){
                copy($copyAppPath . "/android/app/build/outputs/apk/release/app-release.apk", $brandingPath . "app-release.apk");
            }

            $appModel->update($rowID, ["state" => "Cleaning up...", "progress" => 90]);
            //remove directory
            $process = proc_open('rm -R whitewallApp/',
                $descriptorspec,
                $pipes,
                $brandingPath,
                $env
            );

            if (is_resource($process)) {

                // fwrite($pipes[0], "build");
                // fclose($pipes[0]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[1]));
                // fclose($pipes[1]);

                // echo preg_replace("/\r\n|\r|\n/", "<br>", stream_get_contents($pipes[2]));
                // fclose($pipes[2]);

                // It is important that you close any pipes before calling
                // proc_close in order to avoid a deadlock
                $return_value = proc_close($process);
            }

            echo file_get_contents($brandingPath . "app-log.txt");

            $appModel->update($rowID, ["progress" => 100]);
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
