<?php

require_once("model/PostDB.php");
require_once("model/UserDB.php");

class HomeController
{
    // [GET, POST]: home
    public static function index()
    {
        // Fill the home page with five latest posts
        // TODO: implement this using Ajax
        $data = PostDB::getFiveLatest();

        foreach ($data as &$post) {
            $user = UserDB::getUser($post["uid"]);
            $post["user"] = $user;
        }

        ViewHelper::render("view/home/home-page.php", ["posts" => $data]);
    }
}