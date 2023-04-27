<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserValidation implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $page = $arguments[0];

        if (!$session->get("logIn")) {
            $session->setFlashdata('prev_url', $request->getUri()->getPath());
            return redirect()->to("");
        }

        switch($page){
            //TODO: this will be to make sure they can't go there from a url
            
        };

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
