<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\UserModel;
use Google;

class Login extends BaseController
{
    public function index()
    {
        return view('Login') . Navigation::renderFooter(); //TODO: Needs to save in session: Brand Name, Account ID, if logged in
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
            // $client = new Client(["client_id" => getenv("GOOGLE_CLIENT_ID")]);
            $return["success"] = true;
            // $payload = $client->verifyIdToken($google["client_id"]);
            // if ($payload){
            //     echo var_dump($payload);
            // }else{
            //     $return["success"] = false;
            // }
        }else{
            $emails = $userModel->findColumn("email");
            foreach($emails as $email){
                if ($email == $emailInput){
                    if (password_verify($password, $userModel->getUser($email, "email", ["password"], false))){
                        $return["success"] = true;
                        $session->set("logIn", true);
                        $session->set("brand_name", "Beautiful AI");
                        $session->set("user_id", $userModel->getUser($email, "email", ["id"], false));
                    }
                }
            }
        }
        
        return json_encode($return);
    }
}

?>
