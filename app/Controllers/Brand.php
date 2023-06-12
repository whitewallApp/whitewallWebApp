<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;
use App\Models\MenuModel;
use App\Models\UserModel;

class Brand extends BaseController
{
    public function index() //Change brand page
    {
        $session = session();
        $brandModel = new BrandModel;
        $ids = $brandModel->getCollumn("id", $session->get("user_id"));

        $brands = [];

        foreach($ids as $id){
            array_push($brands, $brandModel->getBrand($id, assoc: true));
        }

        $data = [
            "brandInfo" => $brands,
            "admin" => $session->get("is_admin")
        ];

        return Navigation::renderNavBar("Brands",  "brands") . view('brand/Brand', $data) . Navigation::renderFooter();
    }

    public function branding($brandId){
        $session = session();
        $brandModel = new BrandModel();
        $colModel = new CollectionModel();
        $catModel = new CategoryModel();
        $imgModel = new ImageModel();
        $menuModel = new MenuModel();
        $brandname = $session->get("brand_name");

        $categoryIds = $catModel->getCollumn("id", $brandname);
        $categories = [];
        foreach ($categoryIds as $id) {
            $category = $catModel->getCategory($id, filter:["name", "iconPath"], assoc: true);
            array_push($categories, $category);
        }

        $collectionIds = $colModel->getCollumn("id", $brandname);
        $collections = [];
        foreach($collectionIds as $id){
            $collection = $colModel->getCollection($id, ["name", "iconPath"], assoc: true);
            array_push($collections, $collection);
        }

        $imageids = $imgModel->getCollumn("id", $brandname);
        $images = [];
        foreach ($imageids as $id) {
            $image = $imgModel->getImage($id, filter: ["name", "imagePath"], assoc: true);
            array_push($images, $image);
        }

        $menu = $menuModel->getCollumn("title", $session->get("brand_name"));

        $data = [
            "categories" => array_slice($categories, 0, 6),
            "collections" => array_slice($collections, 0, 6),
            "images" => array_slice($images, 0, 6),
            "menu"=> $menu,
            "branding" => $brandModel->getBrand($session->get("brand_name"), "name", ["branding"]),
            "brandimages" => $brandModel->getBrand($session->get("brand_name"), "name", ["appIcon", "appLoading", "appHeading", "appBanner"], true),
        ];

        return Navigation::renderNavBar("Branding","branding", [true, "Brands"]) . view("brand/Branding", $data) . Navigation::renderFooter();
    }

    public function users($brandId){
        $session = session();
        $userModel = new UserModel();
        $userIds = $userModel->getCollumn("id", $session->get("brand_name"));

        $users = [];

        foreach($userIds as $id){
            $user = $userModel->getUser($id, filter: ["name", "email", "id", "brand_id", "status"]);
            array_push($users, $user);
        }

        $data = [
            "users" => $users
        ];

        return Navigation::renderNavBar("Brand Users", [true, "Users"]) . view("brand/Users", $data) . Navigation::renderFooter();
    }

    public function userData(){ //Post
        $session = session();

        if ($session->get("logIn") && $session->get("is_admin")){
            $request = \Config\Services::request();
            $userModel = new UserModel();

            $id = esc($request->getGet("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $user = $userModel->getUser($id, filter: ["name", "email", "status"]);
            $permissions = $userModel->getPermissions($id, $session->get("brand_name"));

            $permissions["admin"] = $userModel->getAdmin($id, $session->get("brand_name"));

            $data = [
                "user" => $user,
                "permissions" => $permissions
            ];

            return json_encode($data);
        }else{
            $this->response->setStatusCode(401);
            return $this->response->send(); 
        }
    }

    public function updateUsers(){
        try {
            $data = $this->request->getPost(["name", "active", "admin", "email", "name", "permissions", FILTER_SANITIZE_FULL_SPECIAL_CHARS]);
            $email = $this->request->getPost("email", FILTER_SANITIZE_EMAIL);
            $id = $this->request->getPost("userId", FILTER_SANITIZE_NUMBER_INT);
            $permissions = $data["permissions"];
            $session = session();

            $userModel = new UserModel();

            $userModel->updatePermissions($id, $permissions);
            $userModel->updateAdmin((int)$id, isset($data["admin"]));

            $user = [
                "name" => $data["name"],
                "email" => $email,
                "status" => isset($data["active"])
            ];

            $userModel->update($id, $user);

            return json_encode(["success" => true]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
            exit;
        }

    }

    public function updateBrand(){
        try {
            $brandModel = new BrandModel();
            $session = session();

            if (count($this->request->getFiles()) > 0){
                $imageType = htmlspecialchars(array_keys($this->request->getFiles())[0]);
                $file = $this->request->getFiles()[$imageType];
                $assets = new Assets();

                //preform checks
                if (!$file->isValid()) {
                    throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
                }
                
                //check if the name of the file has not been modified
                $typeCheck = false;
                foreach(["appIcon", "appLoading", "appHeading", "appBanner"] as $type){
                    if ($imageType == $type){
                        $typeCheck = true;
                    }
                }

                if (!$typeCheck){
                    throw new \RuntimeException("File Name Error");
                }

                $brand = $brandModel->getBrand($session->get("brand_name"), "name", ["id", "appIcon", "appLoading", "appHeading", "appBanner"], true);

                if ($brand[$imageType] == ""){
                    $name = $assets->saveBrandImg($file->getTempName(), explode("/", $file->getMimeType())[1], $imageType);
                    $updatedBrand = [
                        $imageType => "/assets/branding/" . $name
                    ];
                    $brandModel->update($brand["id"], $updatedBrand);
                }else{
                    $name = $assets->updateBrandImg($file->getTempName(), explode("/", $file->getMimeType())[1], explode("/", $brand[$imageType])[3]);
                    $updatedBrand = [
                        $imageType => "/assets/branding/" . $name
                    ];
                    $brandModel->update($brand["id"], $updatedBrand);
                }
            }else{
                //TODO: needs validation and filtering
                $branding = $this->request->getPost("branding");
                $post = $this->request->getPost(["collectionLink", "categoryLink", "menuLink"]);

                $brandId = $brandModel->getBrand($session->get("brand_name"), "name", ["id"]);
                $brandModel->update($brandId, ["branding" => $branding]);

                $colModel = new CollectionModel();
                $catModel = new CategoryModel();

                if ($post["collectionLink"] != ""){
                    $ids = $colModel->getAllIds($session->get("brand_name"));
                    foreach($ids as $id){
                        $collection = $colModel->getCollection($id, assoc: true);
                        $cateogory = $catModel->getCategory($collection["category_id"], assoc: true);

                        $link = preg_replace("/{{collection_id}}/", $id, $post["collectionLink"]);
                        $link = preg_replace("/{{collection_name}}/", urlencode($collection["name"]), $link);
                        $link = preg_replace("/{{category_id}}/", $collection["category_id"], $link);
                        $link = preg_replace("/{{category_name}}/", urlencode($cateogory["name"]), $link);

                        $finalLink = $collection["link"] . $link;
                        $colModel->update($id, ["link" => $finalLink]);
                    }
                }
                if ($post["categoryLink"] != "") {
                    $ids = $catModel->getCollumn("id", $session->get("brand_name"));

                    foreach($ids as $id){
                        $cateogory = $catModel->getCategory($id, assoc: true);

                        $link = preg_replace("/{{category_id}}/", $id, $post["categoryLink"]);
                        $link = preg_replace("/{{category_name}}/", urlencode($cateogory["name"]), $link);

                        $finalLink = $cateogory["link"] . $link;
                        $catModel->update($id, ["link" => $finalLink]);
                    }
                }
                if ($post["menuLink"] != "") {
                    $menuModel = new MenuModel();
                    $ids = $menuModel->getCollumn("id", $session->get("brand_name"));

                    foreach($ids as $id){
                        $menuItem = $menuModel->getMenuItem($id, assoc: true);

                        $link = preg_replace("/{{menu_id}}/", $id, $post["menuLink"]);
                        $link = preg_replace("/{{menu_title}}/", urlencode($menuItem["title"]), $link);

                        $finalLink = $menuItem["externalLink"] . $link;
                        $menuModel->update($id, ["externalLink" => $finalLink]);
                    }
                }
            }

            return json_encode(["success" => true]);

        } catch (\Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    public function setBrand() //Post
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $brandModel = new BrandModel();
            $userModel = new UserModel();
            $name = esc($request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $session = session();

            $brands = $brandModel->getCollumn("name", $session->get("user_id"));
            $success = false;

            foreach($brands as $brand){
                if ($brand["name"] == $name){
                    $success = true;
                }
            }

            if ($success){
                $session->set("brand_name", $name);
                $session->set('is_admin', $userModel->getAdmin($session->get("user_id"), $session->get("brand_name")));
                return json_encode(["success" => true]);
            }

        } else {
            $this->response->setStatusCode(401);
            return $this->response->send(); 
        }
    }
}

?>
