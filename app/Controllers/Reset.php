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

        return view('Reset') . Navigation::renderFooter();
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
                'h:X-Mailgun-Variables'    => json_encode(["link" => "http://localhost/reset/" . $resetKey])
            );

        # Make the call to the client.
        $mgClient->messages()->send($domain, $params);

        return json_encode(["success" => true]);
    }
}
