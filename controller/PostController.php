<?php

require_once("model/PostDB.php");
require_once("model/UserDB.php");

require_once("ViewHelper.php");

class PostController
{

    public static function index()
    {
        // Get details of a specific post
        if (isset($_GET["id"])) {
            ViewHelper::render("view/posts/post-detail.php", ["post" => PostDB::get($_GET["id"])]);
        } // Get list of all posts
        else {
            $posts = PostDB::getAll();

            foreach ($posts as &$post) {
                $user = UserDB::getUser($post["uid"]);
                $post["user"] = $user;
            }


            ViewHelper::render("view/posts/post-list.php", ["posts" => $posts]);
        }
    }
}