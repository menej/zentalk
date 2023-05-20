<?php

require_once("model/PostDB.php");
require_once("model/UserDB.php");

class HomeController
{
    // Show home page (GET: index)
    public static function index()
    {
        // Get 5 latest posts
        $data = PostDB::getFiveLatest();

        foreach ($data as &$post) {
            $user = UserDB::getUser($post["uid"]);
            $post["user"] = $user;
        }

        ViewHelper::render("view/home/home-page.php", ["posts" => $data]);
    }
}