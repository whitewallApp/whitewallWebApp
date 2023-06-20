<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class Edit implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $page = $arguments[0];
        $thisrequest = \Config\Services::request();

        if ($thisrequest->getPost("id") == 'undefined'){
           $Add = new Add();
           $Add->before($request, $arguments);
        }else{

            if (!$session->get("logIn")){
                http_response_code(403);
                die(json_encode(["success" => false, "message" => "You Need to be logged in"]));
            }

            if (isset($arguments[1]) && $arguments[1] == "admin"){
                if (!$session->get("is_admin")){
                    http_response_code(403);
                    die(json_encode(["success" => false, "message" => "You have to be an admin"]));
                }
            }

            if (!$session->get("is_admin")){
                $userModel = new UserModel();

                $canEdit = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"), permissions: ["p_edit"]);

                if (!$canEdit[$page]["p_edit"]){
                    http_response_code(403);
                    die(json_encode(["success" => false, "message" => "You don't have permissions to edit"]));
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
