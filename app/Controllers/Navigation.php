<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\UserModel;

class Navigation extends BaseController
{
    public static function renderNavBar($pageTitle, $actions = [])
    {
        $brandModel = new BrandModel;
        $userModel = new UserModel();
        $session = session();

        //TODO: put a view array here 

        $canView = $userModel->getPermissions($session->get("user_id"), $session->get("brand_name"), permissions: ["p_view", "p_edit"]);

        // echo var_dump($canView);

        $data = [
            "brands" => $brandModel->getCollumn(["name", "logo"], $session->get("user_id")),
            "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
            "brandName" => $session->get("brand_name"),
            "brandIcon" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["logo"]),
            "userIcon" => $userModel->getUser($session->get("user_id"), filter: ["icon"]),
            "pageTitle" => $pageTitle,
            "actions" => $actions,
            "view" => $canView,
            "admin" => $session->get("is_admin")
        ];


        return view('Navigation', $data);
    }

    public static function renderFooter(){
        return '</body></html><!-- MDB -->
        <script type="text/javascript" src="/js/mdb.min.js"></script>
        <script src="/js/notifications.js"></script>
        <script src="/js/breadcrumbs.js"></script>
        <script src="/js/getset.js"></script>
        <script src="/js/actions.js"></script>
        <script src="https://accounts.google.com/gsi/client" async defer></script>';
    }
}
