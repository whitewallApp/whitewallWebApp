<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Edit implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $page = $arguments[0];

        if (!$session->get("logIn")){
            http_response_code(403);
            die('Not logged in');
        }

        if (isset($arguments[1]) && $arguments[1] == "admin"){
            if (!$session->get("is_admin")){
                http_response_code(403);
                die('Need to be admin');
            }
        }

        $userModel = new UserModel();

        $canEdit = $userModel->getPermissions($session->get("user_id"), $session->get("brand_name"), permissions: ["p_edit"]);

        if (!$canEdit[$page]["p_edit"]){
            http_response_code(403);
            die(json_encode(["success" => false, "message" => "You don't have permissions"]));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
