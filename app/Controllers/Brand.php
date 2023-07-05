<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;
use App\Models\MenuModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class Brand extends BaseController
{
    public function index() //Change brand page
    {
        $session = session();
        $brandModel = new BrandModel;
        $userModel = new UserModel();
        $ids = $brandModel->getCollumn("id", $session->get("user_id"));

        $brands = [];

        foreach($ids as $id){
            array_push($brands, $brandModel->getBrand($id, assoc: true));
        }

        $data = [
            "default" => $userModel->getUser($session->get("user_id"), filter: ["default_brand"]),
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
        $brandname = $session->get("brand_id");

        $categoryIds = $catModel->getCollumn("id", $brandname);
        $categories = [];
        foreach ($categoryIds as $id) {
            $category = $catModel->getCategory($id, filter:["name", "iconPath"], assoc: true);
            
            if ($category["name"] == "Default Category") {
                continue;
            }

            array_push($categories, $category);
        }

        $collectionIds = $colModel->getCollumn("id", $brandname);
        $collections = [];
        foreach($collectionIds as $id){
            $collection = $colModel->getCollection($id, ["name", "iconPath"], assoc: true);

            if ($collection["name"] == "Default Collection"){
                continue;
            }

            array_push($collections, $collection);
        }

        $imageids = $imgModel->getCollumn("id", $brandname);
        $images = [];
        foreach ($imageids as $id) {
            $image = $imgModel->getImage($id, filter: ["name", "thumbnail", "imagePath"], assoc: true);
            array_push($images, $image);
        }

        $menu = $menuModel->getCollumn("title", $session->get("brand_id"));

        $data = [
            "categories" => array_slice($categories, 0, 6),
            "collections" => array_slice($collections, 0, 6),
            "images" => array_slice($images, 0, 6),
            "menu"=> $menu,
            "branding" => $brandModel->getBrand($session->get("brand_id"), filter: ["branding"]),
            "brandimages" => $brandModel->getBrand($session->get("brand_id"), filter: ["appIcon", "appLoading", "appHeading", "appBanner"], assoc: true),
        ];

        return Navigation::renderNavBar("Branding","branding") . view("brand/Branding", $data) . Navigation::renderFooter();
    }

    public function users($brandId){
        $brandId = filter_var($brandId, FILTER_VALIDATE_INT);

        $session = session();
        $userModel = new UserModel();
        $brandModel = new BrandModel();
        $users = [];
        $accountUsers = [];

        $brandIds = $brandModel->getCollumn("id", $session->get("user_id"));

        foreach($brandIds as $dbId){

            if ($dbId["id"] == $brandId){
                $userIds = $userModel->getCollumn("id", $brandId);

                foreach($userIds as $id){
                    $user = $userModel->getUser($id, filter: ["name", "email", "id", "brand_id", "status", "icon"]);
                    array_push($users, $user);
                }

                //get the account users
                $accountId = $userModel->getUser($session->get("user_id"), filter: ["account_id"]);
                $accountUserIds = $userModel->getCollumn("id", $accountId, getBy: "account_id");
                foreach($accountUserIds as $dbuserId){
                    if ($dbuserId["id"] != $session->get("user_id")){
                        array_push($accountUsers, $userModel->getUser($dbuserId["id"], filter: ["id", "name", "icon"]));
                    }
                }
            }

        }

        $data = [
            "users" => $users,
            "accountUsers" => $accountUsers,
            "session" => $session
        ];

        return Navigation::renderNavBar("Brand Users", [true, "Users"]) . view("brand/Users", $data) . Navigation::renderFooter();
    }

    public function userData(){ //Post
        $session = session();

        if ($session->get("logIn") && $session->get("is_admin")){
            $request = \Config\Services::request();
            $userModel = new UserModel();
            $brandModel = new BrandModel();

            $id = esc($request->getGet("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $user = $userModel->getUser($id, filter: ["name", "email", "status", "phone", "id"]);
            $permissions = $userModel->getPermissions($id, $session->get("brand_id"));

            $permissions["admin"] = $userModel->getAdmin($id, $session->get("brand_id"));

            $data = [
                "user" => $user,
                "numBrands" => count($brandModel->getCollumn("id", $id)),
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
            $data = $this->request->getPost(["name", "active", "admin", "email", "name", "permissions","phone", FILTER_SANITIZE_FULL_SPECIAL_CHARS]);
            $email = $this->request->getPost("email", FILTER_SANITIZE_EMAIL);
            $id = $this->request->getPost("userId", FILTER_SANITIZE_NUMBER_INT);
            $permissions = $data["permissions"];
            $session = session();

            $userModel = new UserModel();

            if ($id != ""){
                $userModel->updatePermissions($id, $permissions);
                $userModel->updateAdmin((int)$id, isset($data["admin"]));

                $user = [
                    "name" => $data["name"],
                    "email" => $email,
                    "status" => isset($data["active"]),
                    "phone" => $data["phone"]
                ];

                $userModel->update($id, $user);

                return json_encode(["success" => true]);
            }else{
                //check if they have reached the limit

                $subModel = new SubscriptionModel();
                $userLimit = $subModel->getLimit($session->get("user_id"), "userLimit");
                if ($subModel->checkUserLimit($session->get("user_id"), $userLimit)) {
                    throw new \RuntimeException("User Limit Reached");
                }

                //TODO: send email with temp password
                $password = password_hash("test", PASSWORD_DEFAULT);

                $userData = [
                    "name" => $data["name"],
                    "email" => $email,
                    "phone" => $data["phone"],
                    "status" => isset($data["active"]),
                    "password" => $password
                ];
                $userModel->addUser($userData, $session->get("brand_id"), $permissions, isset($data["admin"]));
            }
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
            exit;
        }

    }

    public function addBrand(){
        try {
            $brandModel = new BrandModel();
            $userModel = new UserModel();
            $session = session();

            $name = $this->request->getPost("name", FILTER_SANITIZE_SPECIAL_CHARS);
            $import = $this->request->getPost("import", FILTER_VALIDATE_BOOL);


            $accountID = $userModel->getUser($session->get("user_id"), filter: ["account_id"]);

            $brand = [
                "name" => $name,
                "account_id" => $accountID,
                "apikey" => bin2hex(random_bytes(32))
            ];

            $brandID = $brandModel->insert($brand);

            $filePath = "";
            if (count($this->request->getFiles()) > 0) {
                $file = $this->request->getFile("logo");
                //preform checks
                if (!$file->isValid()) {
                    throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
                }

                $assets = new Assets();
                $name = $assets->saveBrandImg($file->getTempName(), $file->guessExtension(), "logo", $brandID);

                $filePath = "/assets/branding/" . $brandID . "/" . $name;
                $brandModel->update($brandID, ["logo" => $filePath]);
            }

            $brandModel->joinUser($brandID, $session->get("user_id"), true);

            //create default category & collections
            $colModel = new CollectionModel();
            $catModel = new CategoryModel();
            $category = [
                "name" => "Default Category",
                "brand_id" => $brandID
            ];
            $categoryID = $catModel->insert($category);

            $collection = [
                "name" => "Default Collection",
                "brand_id" => $brandID,
                "category_id" => $categoryID
            ];
            $colModel->insert($collection);

            if ($import){
                $userIds = $userModel->getCollumn("id", $session->get("brand_id"));
                foreach ($userIds as $userId) {
                    $userId = $userId["id"];
                    $userModel->setPermissions($userId, $brandID, $userModel->getPermissions($userId, $session->get("brand_id")));
                    if ($userId != $session->get("user_id")){
                        $brandModel->joinUser($brandID, $userId, $userModel->getAdmin($userId, $session->get("brand_id")));
                    }
                }
            }
        } catch (\Throwable $e) {
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
                foreach(["appIcon", "appLoading", "appHeading", "appBanner", "logo"] as $type){
                    if ($imageType == $type){
                        $typeCheck = true;
                    }
                }

                if (!$typeCheck){
                    throw new \RuntimeException("File Name Error");
                }

                $getbrandID = $session->get("brand_id");

                if (!is_null($this->request->getPost("id"))){
                    $id = $this->request->getPost("id", FILTER_VALIDATE_INT);

                    $dbids = $brandModel->getCollumn("id", $session->get("user_id"));
                    //if they can edit that brand
                    foreach ($dbids as $dbid) {
                        $dbid = $dbid["id"];
                        if ($dbid == $id) {
                            $getbrandID = $dbid;
                        }
                    }
                }

                $brand = $brandModel->getBrand($getbrandID, filter: ["id", "appIcon", "appLoading", "appHeading", "appBanner", "logo"], assoc: true);

                if ($this->request->getPost("name") != null) {
                    $name = $this->request->getPost("name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $brandModel->update($brand["id"], ["name" => $name]);
                }

                //if we seting it for the first time else delete old file
                if ($brand[$imageType] == "" || preg_match("/^http/", $brand[$imageType]) == "1"){
                    $name = $assets->saveBrandImg($file->getTempName(), explode("/", $file->getMimeType())[1], $imageType, $getbrandID);
                    $updatedBrand = [
                        $imageType => "/assets/branding/" . $getbrandID . "/" . $name
                    ];
                    $brandModel->update($brand["id"], $updatedBrand);
                }else{
                    $name = $assets->updateBrandImg($file->getTempName(), explode("/", $file->getMimeType())[1], explode("/", $brand[$imageType])[3], $getbrandID);
                    $updatedBrand = [
                        $imageType => "/assets/branding/" . $getbrandID . "/" . $name
                    ];
                    $brandModel->update($brand["id"], $updatedBrand);
                }
            }else{
                //TODO: needs validation and filtering
                $branding = $this->request->getPost("branding");
                $post = $this->request->getPost(["collectionLink", "categoryLink", "menuLink"]);

                $brandId = $session->get("brand_id");
                $brandModel->update($brandId, ["branding" => $branding]);

                $colModel = new CollectionModel();
                $catModel = new CategoryModel();

                //update brandname if it comes in
                if ($this->request->getPost("name") != null) {
                    $name = $this->request->getPost("name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $id = $this->request->getPost("id", FILTER_VALIDATE_INT);
                    $dbids = $brandModel->getCollumn("id", $session->get("user_id"));
                    //if they can edit that brand
                    foreach ($dbids as $dbid) {
                        $dbid = $dbid["id"];
                        if ($dbid == $id){
                            $brandModel->update($dbid, ["name" => $name]);
                        }
                    }
                }

                if ($post["collectionLink"] != ""){
                    $ids = $colModel->getAllIds($session->get("brand_id"));
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
                    $ids = $catModel->getCollumn("id", $session->get("brand_id"));

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
                    $ids = $menuModel->getCollumn("id", $session->get("brand_id"));

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

    public function removeBrand(){
        $brandModel = new BrandModel();
        $assets = new Assets();

        $brandName = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);
        $brandId = $brandModel->getBrand($brandName, "name", ["id"]);

        $assets->removeBrand($brandId);
        $brandModel->delete($brandId);
    }

    public function removeUser(){
        $userModel = new UserModel();
        $userID = $this->request->getPost("id", FILTER_SANITIZE_NUMBER_INT);
        $assets = new Assets();

        try {
            $session = session();
            if ($userID != $session->get("user_id")) {
                $assets->removeUser($userID);
                $userModel->delete($userID);
            }
        } catch (\Throwable $e) {
            http_response_code(403);
            return json_encode($e->getMessage());
            exit;
        }
    }

    public function unlinkUser(){
        $id = $this->request->getPost("id", FILTER_SANITIZE_NUMBER_INT);
        
        if ($id != null){
            $userModel = new UserModel();
            $brandModel = new BrandModel();
            $session = session();

            $brandId = $session->get("brand_id");
            $userIds = $userModel->getCollumn("id", $brandId);

            if ($id != $session->get("user_id")){
                if (count($brandModel->getCollumn("id", $id)) > 1){
                    foreach($userIds as $userID){
                        $userID = $userID["id"];

                        if ($userID == $id){
                            $brandModel->unlinkUser($userID, $brandId);
                        }
                    }
                }
            }
        }

        return json_encode(["success" => true]);
    }

    public function linkUser(){
        $id = $this->request->getPost("id", FILTER_SANITIZE_NUMBER_INT);

        if ($id != null) {
            $userModel = new UserModel();
            $brandModel = new BrandModel();
            $session = session();

            $brandId = $session->get("brand_id");

            //get the account users
            $accountId = $userModel->getUser($session->get("user_id"), filter: ["account_id"]);
            $userIds = $userModel->getCollumn("id", $accountId, getBy: "account_id");

            foreach ($userIds as $userID) {
                $userID = $userID["id"];

                if ($userID == $id) {
                    $brandModel->joinUser($brandId, $userID);
                    $userModel->setPermissions($userID, $brandId);
                }
            }
        }

        return json_encode(["success" => true]);
    }

    public function setBrand() //Post
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $brandModel = new BrandModel();
            $userModel = new UserModel();

            //update session brand
            if ($request->getPost("name") != null){
                $name = $request->getPost("name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $brands = $brandModel->getCollumn("name", $session->get("user_id"));
                $success = false;

                foreach ($brands as $brand) {
                    if ($brand["name"] == $name) {
                        $success = true;
                    }
                }

                if ($success) {
                    $id = $brandModel->getBrand($name, "name", ["id"]);
                    $session->set("brand_id", $id);
                    $session->set('is_admin', $userModel->getAdmin($session->get("user_id"), $session->get("brand_id")));
                    return json_encode(["success" => true]);
                }
            }

            //set a defalt brand if it comes in
            if ($request->getPost("default") != null) {
                $brandids = $brandModel->getCollumn("id", $session->get("user_id"));
                $postId = $request->getPost("default", FILTER_VALIDATE_INT);

                foreach ($brandids as $brandId) {
                    if ($brandId["id"] == $postId){
                        $userModel->update($session->get("user_id"), ["default_brand" => $postId]);
                        return json_encode(["success" => true]);
                    }
                }
            }

        } else {
            $this->response->setStatusCode(401);
            return $this->response->send(); 
        }
    }
}

?>
