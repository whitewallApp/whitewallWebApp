<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Add implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $page = $arguments[0];

        if (!$session->get("logIn")) {
            http_response_code(403);
            die(json_encode(["success" => false, "message" => "You Need to be logged in"]));
        }

        if (isset($arguments[1]) && $arguments[1] == "admin") {
            if (!$session->get("is_admin")) {
                http_response_code(403);
                die(json_encode(["success" => false, "message" => "You have to be an admin"]));
            }
        }

        $userModel = new UserModel();

        $canEdit = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"), permissions: ["p_add"]);

        if (!$canEdit[$page]["p_add"]) {
            http_response_code(403);
            die(json_encode(["success" => false, "message" => "You don't have permissions"]));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
