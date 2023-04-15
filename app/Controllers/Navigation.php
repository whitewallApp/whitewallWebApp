<?php

namespace App\Controllers;

use App\Models\BrandModel;

class Navigation extends BaseController
{
    public static function renderNavBar($pageTitle)
    {
        $brandModel = new BrandModel;
        $session = session();

        $data = [
            "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
            "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
            "pageTitle" => $pageTitle
        ];


        return view('Navigation', $data);
    }

    public static function renderFooter(){
        return '</body></html><!-- MDB -->
        <script type="text/javascript" src="/js/mdb.min.js"></script>
        <script src="/js/notifications.js"></script>
        <script src="/js/breadcrumbs.js"></script>
        <script src="/js/getset.js"></script>
        <script src="/js/actions.js"></script>';
    }
}
