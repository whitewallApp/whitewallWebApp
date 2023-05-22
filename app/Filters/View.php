<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class View implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $page = $arguments[0];
        $userModel = new UserModel();

        if (!$session->get("logIn")) {
            $session->setFlashdata('prev_url', $request->getUri()->getPath());
            return redirect()->to("");
        }

        if($page == "admin"){
            if (!$session->get("is_admin")){
                $session->setFlashdata('prev_url', $request->getUri()->getPath());
                return redirect()->to("");
            }
        }else{
            if ($page != "nocheck") {
                $canView = $userModel->getPermissions($session->get("user_id"), $session->get("brand_name"), permissions: ["p_view"]);
                if (!$canView[$page]["p_view"]) {
                    $session->setFlashdata('prev_url', "dashboard");
                    return redirect()->to("");
                }
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
