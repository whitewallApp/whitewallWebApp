<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateForignKey extends Migration
{
    public function up()
    {
        //Update brand table
        $this->forge->dropForeignKey('brand', 'fk_brand_account');
        $this->forge->addForeignKey("account_id", "account", "id", "NO ACTION", "CASCADE", "fk_brand_account");
        $this->forge->processIndexes('brand');

        //update branduser
        $this->forge->dropForeignKey('branduser', 'fk_brand_user_brand');
        $this->forge->dropForeignKey('branduser', 'fk_brand_user_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_brand_user_brand");
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "CASCADE", "fk_brand_user_id");
        $this->forge->processIndexes('branduser');

        //Update category table
        $this->forge->dropForeignKey('category', 'fk_category_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_category_brand_id");
        $this->forge->processIndexes('category');

        //update collection table
        $this->forge->dropForeignKey('collection', 'fk_collection_brand_id');
        $this->forge->dropForeignKey('collection', 'fk_collection_category_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_collection_brand_id");
        $this->forge->addForeignKey("category_id", "category", "id", "NO ACTION", "CASCADE", "fk_collection_category_id");
        $this->forge->processIndexes('collection');

        //Update menu table
        $this->forge->dropForeignKey('menu', 'fk_menu_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_menu_brand_id");
        $this->forge->processIndexes('menu');

        //Update notifications table
        $this->forge->dropForeignKey('notifications', 'fk_notifications_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_notifications_brand_id");
        $this->forge->processIndexes('notifications');

        //update permissions table
        $this->forge->dropForeignKey('permissions', 'fk_permissions_brand_id');
        $this->forge->dropForeignKey('permissions', 'fk_permissions_user_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_permissions_brand_id");
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "CASCADE", "fk_permissions_user_id");
        $this->forge->processIndexes('permissions');

        //Update resetkeys table
        $this->forge->dropForeignKey('resetkeys', 'fk_keys_user_id');
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "CASCADE", "fk_keys_user_id");
        $this->forge->processIndexes('resetkeys');

        //update user table
        $this->forge->dropForeignKey('user', 'fk_user_account_id');
        $this->forge->dropForeignKey('user', 'fk_user_brand_id');
        $this->forge->addForeignKey("account_id", "account", "id", "NO ACTION", "CASCADE", "fk_user_account_id");
        $this->forge->addForeignKey("default_brand", "brand", "id", "NO ACTION", "CASCADE", "fk_user_brand_id");
        $this->forge->processIndexes('user');

        //update wallpaper table
        $this->forge->dropForeignKey('wallpaper', 'fk_wallpaper_brand_id');
        $this->forge->dropForeignKey('wallpaper', 'fk_walpaper_collectioni_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "CASCADE", "fk_wallpaper_brand_id");
        $this->forge->addForeignKey("collection_id", "collection", "id", "NO ACTION", "CASCADE", "fk_walpaper_collectioni_id");
        $this->forge->processIndexes('wallpaper');
    }

    public function down()
    {
        //Update brand table
        $this->forge->dropForeignKey('brand', 'fk_brand_account');
        $this->forge->addForeignKey("account_id", "account", "id", "NO ACTION", "NO ACTION", "fk_brand_account");
        $this->forge->processIndexes('brand');

        //update branduser
        $this->forge->dropForeignKey('branduser', 'fk_brand_user_brand');
        $this->forge->dropForeignKey('branduser', 'fk_brand_user_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_brand_user_brand");
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "NO ACTION", "fk_brand_user_id");
        $this->forge->processIndexes('branduser');

        //Update category table
        $this->forge->dropForeignKey('category', 'fk_category_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_category_brand_id");
        $this->forge->processIndexes('category');

        //update collection table
        $this->forge->dropForeignKey('collection', 'fk_collection_brand_id');
        $this->forge->dropForeignKey('collection', 'fk_collection_category_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_collection_brand_id");
        $this->forge->addForeignKey("category_id", "category", "id", "NO ACTION", "NO ACTION", "fk_collection_category_id");
        $this->forge->processIndexes('collection');

        //Update menu table
        $this->forge->dropForeignKey('menu', 'fk_menu_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_menu_brand_id");
        $this->forge->processIndexes('menu');

        //Update notifications table
        $this->forge->dropForeignKey('notifications', 'fk_notifications_brand_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_notifications_brand_id");
        $this->forge->processIndexes('notifications');

        //update permissions table
        $this->forge->dropForeignKey('permissions', 'fk_permissions_brand_id');
        $this->forge->dropForeignKey('permissions', 'fk_permissions_user_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_permissions_brand_id");
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "NO ACTION", "fk_permissions_user_id");
        $this->forge->processIndexes('permissions');

        //Update resetkeys table
        $this->forge->dropForeignKey('resetkeys', 'fk_keys_user_id');
        $this->forge->addForeignKey("user_id", "user", "id", "NO ACTION", "NO ACTION", "fk_keys_user_id");
        $this->forge->processIndexes('resetkeys');

        //update user table
        $this->forge->dropForeignKey('user', 'fk_user_account_id');
        $this->forge->dropForeignKey('user', 'fk_user_brand_id');
        $this->forge->addForeignKey("account_id", "account", "id", "NO ACTION", "NO ACTION", "fk_user_account_id");
        $this->forge->addForeignKey("default_brand", "brand", "id", "NO ACTION", "NO ACTION", "fk_user_brand_id");
        $this->forge->processIndexes('user');

        //update wallpaper table
        $this->forge->dropForeignKey('wallpaper', 'fk_wallpaper_brand_id');
        $this->forge->dropForeignKey('wallpaper', 'fk_walpaper_collectioni_id');
        $this->forge->addForeignKey("brand_id", "brand", "id", "NO ACTION", "NO ACTION", "fk_wallpaper_brand_id");
        $this->forge->addForeignKey("collection_id", "collection", "id", "NO ACTION", "NO ACTION", "fk_walpaper_collectioni_id");
        $this->forge->processIndexes('wallpaper');
    }
}
