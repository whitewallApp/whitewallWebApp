<?php

namespace App\Controllers;
use App\Models\MenuModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\UserModel;
use Google\Service\CloudAsset\Asset;
use \HTMLPurifier_Config;
use \HTMLPurifier;

class Menu extends BaseController
{
    public function index()
    {
        $session = session();
        $menuModel = new MenuModel;
        $brandModel = new BrandModel;

        $ids = $menuModel->getCollumn("id", $session->get("brand_id"));

        $menuItems = [];

        foreach($ids as $id){
            array_push($menuItems, $menuModel->getMenuItem($id, assoc: true));
        }

        $data = [
            "menuItems" => $menuItems,
        ];

        return Navigation::renderNavBar("Menu Items", "menu") . view('Menu', $data) . Navigation::renderFooter();
    }

    public function post(){
        $menuModel = new MenuModel();
        $name = $this->request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $menuItem = $menuModel->getMenuItem($name, fetchBy: "title", assoc: true);

        return json_encode($menuItem);
    }

    public function update(){
        //TODO: handle file Uploads
        $menuModel = new MenuModel();
        $userModel = new UserModel();
        $session = session();
        try {
            $post = $this->request->getPost(["id", "title", "sequence", "target"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $permission = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"), ["images"], ["p_add"]);

            $data = [
                "title" => $post["title"],
                "sequence" => $post["sequence"],
                "target" => $post["target"]
            ];

            if ($data["target"] == "1"){
                $link = $this->request->getPost("link", FILTER_SANITIZE_URL);
                $data["link"] = $link;
                $data["internalContext"] = "";
            }else{
                $html = $this->request->getPost("internalContext");
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);

                $cleanHtml = $purifier->purify($html);
                $data["link"] = "";
                $data["internalContext"] = $cleanHtml;
            }

            if ($post["id"] == "undefined" && $permission){
                $brandModel = new BrandModel();
                $session = session();
                $data["brand_id"] = $brandModel->getBrand($session->get("brand_id"), "name", ["id"]);

                $menuModel->save($data);
            }else{
                $menuModel->update($post["id"], $data);
            }
            return json_encode(["success" => true]);

            //THIS IS OLD CODE FOR WYSIWYG
            // if (count($_FILES) > 0){ //TODO: this doesn't delete old files
            //     $assets = new Assets();
            //     $return = [];

            //     foreach($_FILES as $file){
            //         $tmpName = htmlspecialchars($file["tmp_name"]);
            //         $type = explode("/", $file["type"])[1];

            //         $name = $assets->saveMenu($tmpName, $type);

            //         $return = ["link" => "/assets/menu/" . $name];
            //     }

            //     return json_encode($return);
            // }
        } catch (\Exception $e){
            http_response_code(400);
            return json_encode($e->getMessage());
            exit;
        }
    }

    public function delete()
    {
        try {
            $menuModel = new MenuModel();
            $session = session();

            if ($this->request->getPost("ids") != null) {
                $ids = filter_var_array(json_decode((string)$this->request->getPost("ids")), FILTER_SANITIZE_SPECIAL_CHARS);
                $dbids = $menuModel->getCollumn("id", $session->get("brand_id"));

                $numIds = [];
                foreach($ids as $id){
                    array_push($numIds, $menuModel->getMenuItem($id, ["id"], "title"));
                }

                $vallidIds = array_intersect($dbids, $numIds);

                $menuModel->delete($vallidIds);
            } else {
                $id = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);
                $dbids = $menuModel->getCollumn("id", $session->get("brand_id"));

                foreach ($dbids as $dbid) {
                    if ($dbid == $id) {
                        $menuModel->delete($id);
                    }
                }
            }
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode($e->getMessage());
            exit;
        }
    }

}

?>