<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\ResetModel;
use App\Models\UserModel;
use Mailgun\Mailgun;

class Reset extends BaseController

{
    public function index($key)
    {
        $resetModel = new ResetModel();

        $found = false;
        $keys = $resetModel->findColumn("reset_key");

        if($keys != null){
            foreach($keys as $dbkey){
                if($dbkey == $key){
                    $found = true;
                }
            }

            if ($found){
                return view('Reset', ["key" => $key]) . Navigation::renderFooter();
            }else{
                return view("errors/html/error_404", ["message" => "Not a Valid Key"]);
            }
        }else{
            return view("errors/html/error_404", ["message" => "No Key Found"]);
        }
    }

    public function update(){
        $password = esc($this->request->getPost("password"));
        $reset_key = esc($this->request->getPost("key"));
        $chars = true;
        $symbol = true;
        $number = true;
        $capital = true;
        $msg = "";

        if(!strlen($password) >= 8){
            $chars = false;
            $msg . "Not 8 characters<br>";
        }

        if(!preg_match("/\W/", $password)){
            $symbol = false;
            $msg . "Needs a symbol<br>";
        }

        if (!preg_match("/\d/", $password)){
            $number = false;
            $msg . "Needs a number<br>";
        }

        if (!preg_match("/[A-Z]/", $password)){
            $capital = false;
            $msg . "Need a capital letter<br>";
        }

        if ($chars && $symbol && $number && $capital){
            $resetModel = new ResetModel();
            $userModel = new UserModel();

            $userId = $resetModel->where("reset_key", $reset_key)->first()["user_id"];
            $rowId = $resetModel->where("reset_key", $reset_key)->first()["id"];
            $userModel->update($userId, ["password" => password_hash($password, PASSWORD_DEFAULT)]);
            $resetModel->delete($rowId);

            LogIn::login($userId);

            return json_encode(["success" => true]);
        }else{
            return json_encode(["success" => false, "msg" => $msg]);
        }
    }

    public function post(){
        $resetModel = new ResetModel();
        $userModel = new UserModel();
        $email = esc($this->request->getPost("email", FILTER_VALIDATE_EMAIL));

        //If the email is not a valid email
        if(!$email){
            return json_encode(["success" => false, "message" => "Please Input a valid email"]);
            die();
        }

        //Make sure the user has an email on our database
        $emails = $userModel->findColumn("email");
        $found = false;
        foreach($emails as $dataEmail){
            if ($email == $dataEmail){
                $found = true;
            }
        }

        if (!$found){
            return json_encode(["success" => false, "message" => "Please Input a valid email"]);
            die();
        }

        //add the user to the reset keys
        $userid = $userModel->getUser($email, "email", ["id"]);
        $resetKey = md5(uniqid());

        $resetModel->insert(["user_id" => $userid, "reset_key" => $resetKey]);

        //email the client
        $mgClient = Mailgun::create(getenv("MAILGUN_API"), getenv("MAILGUN_URL"));
        $domain = "support.whitewall.app";
        $params = array(
                'from'    => 'Support <support@whitewall.app>',
                'to'      => $email,
                'subject' => 'Password Reset at Whitewall',
                'template'    => 'password_reset',
                'text'    => 'Testing some Mailgun awesomness!',
                'h:X-Mailgun-Variables'    => json_encode(["link" => getenv("app.baseURL") . "reset/" . $resetKey])
            );

        # Make the call to the client.
        $mgClient->messages()->send($domain, $params);

        return json_encode(["success" => true]);
    }
}
