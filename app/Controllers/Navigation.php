<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\UserModel;

class Navigation extends BaseController
{
    /**
     * Renders the Navigation bar and everything assosiated with it
     *
     * @param string $pageTitle The name to display on the bread crumbs
     * @param string $pageName The database permission category for the page
     * @param array $actions [0] => if to display the upload buttons, [1] => the name of what to add on the UI
     * @return string html to render
     */
    public static function renderNavBar($pageTitle, $pageName = "nopermission", $actions = [])
    {
        $brandModel = new BrandModel;
        $userModel = new UserModel();
        $session = session();

        $canView = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"));

        // echo var_dump($canView);

        $data = [
            "brands" => $brandModel->getCollumn(["name", "logo"], $session->get("user_id")),
            "brandId" => $session->get("brand_id"),
            "brandName" => $brandModel->getBrand($session->get("brand_id"), filter: ["name"]),
            "brandIcon" => $brandModel->getBrand($session->get("brand_id"), filter: ["logo"]),
            "userIcon" => $userModel->getUser($session->get("user_id"), filter: ["icon"]),
            "pageTitle" => $pageTitle,
            "actions" => $actions,
            "view" => $canView,
            "pageName" => $pageName,
            "admin" => $session->get("is_admin")
        ];


        return view('Navigation', $data);
    }

    public static function renderFooter(){
        return '</body></html><!-- MDB -->
        <script type="text/javascript" src="/js/mdb.min.js"></script>
        <script src="/js/breadcrumbs.js"></script>
        <script src="/js/getset.js"></script>
        <script src="/js/actions.js"></script>
        <script src="https://accounts.google.com/gsi/client" async defer></script>';
    }
}
