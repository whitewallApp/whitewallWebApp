<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\UserModel;
use Google;

class Login extends BaseController
{
    public function index()
    {
        return view('Login') . Navigation::renderFooter();
    }

    public function post(){
        $session = session();
        $request = \Config\Services::request();
        $return = ["success" => false];
        $userModel = new UserModel();

        $emailInput = esc($request->getPost("email"));
        $password = esc($request->getPost("password"));
        $google = esc($request->getPost("google"));

        if (isset($google)){
            $client = new Google\Client(["client_id" => $google["clientId"]]);
            $payload = $client->verifyIdToken($google["credential"]);
            if ($payload){
                $googleIds = $userModel->findColumn("google_id");

                foreach($googleIds as $id){
                    if ($id == $payload["sub"]){

                        $return["success"] = true;

                        $session->set("logIn", true);
                        $session->set("brand_name", "Beautiful AI");
                        $session->set("user_id", $userModel->getUser($id, "user.google_id", ["id"]));
                        $session->set("is_admin", $userModel->getUser($session->get("user_id"), filter: ["admin"]));
                    }
                }
            }
        }else{
            $emails = $userModel->findColumn("email");
            foreach($emails as $email){
                if ($email == $emailInput){
                    if (password_verify($password, $userModel->getUser($email, "email", ["password"]))){
                        $return["success"] = true;
                        $session->set("logIn", true);
                        $session->set("brand_name", "Beautiful AI");
                        $session->set("user_id", $userModel->getUser($email, "email", ["id"]));
                        $session->set("is_admin", $userModel->getUser($session->get("user_id"), filter: ["admin"]));
                    }
                }
            }
        }
        
        return json_encode($return);
    }
}

?>
