<?php

require_once("model/FavouriteDB.php");
require_once("model/PostDB.php");
require_once("model/UserDB.php");

class FavouriteController
{
    public static function favourites()
    {
        // Check if user is logged in
        if (empty($_SESSION["user"])) {
            ViewHelper::redirect(BASE_URL . "login");
            return;
        }

        $favourites = FavouriteDB::getFavourites($_SESSION["user"]["uid"]);

        $posts = [];

        foreach ($favourites as $favourite) {
            $post = PostDB::get($favourite["pid"]);
            $user = UserDB::getUser($post["uid"]);
            $post["user"] = $user;

            $posts[] = $post;
        }

        $vars = ["user" => $_SESSION["user"], "posts" => $posts];

        ViewHelper::render("view/users/user-favourites.php", $vars);
    }

    // POST: favourites/add
    public static function addFavourite()
    {
        // Check if user is logged in
        if (empty($_SESSION["user"])) {
            ViewHelper::redirect(BASE_URL . "login");
            return;
        }

        // Check if there is PID in this POST request
        if (empty($_POST["pid"])) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // Check if PID exists
        $pid = $_POST["pid"];

        // Check if post exists
        try {
            $post = PostDB::get($pid);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // Check if favourite already exists
        // TODO: should return an error message back to the user (or show him un favourite)
        if (FavouriteDB::favouriteExists($pid, $_SESSION["user"]["uid"])) {
            ViewHelper::redirect(BASE_URL . "post/detail?pid=" . $post["pid"]);
            return;
        }

        FavouriteDB::addFavourite($_SESSION["user"]["uid"], $post["pid"]);

        ViewHelper::redirect(BASE_URL . "post/detail?pid=" . $post["pid"]);
    }

    public static function removeFavourite()
    {
        // Check if user is logged in
        if (empty($_SESSION["user"])) {
            ViewHelper::redirect(BASE_URL . "login");
            return;
        }

        // Check if there is PID in this POST request
        if (empty($_POST["pid"])) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // Check if PID exists
        $pid = $_POST["pid"];

        // Check if post exists
        try {
            $post = PostDB::get($pid);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        if (FavouriteDB::favouriteExists($pid, $_SESSION["user"]["uid"])) {
            FavouriteDB::removeFavourite($_SESSION["user"]["uid"], $post["pid"]);
        }


        ViewHelper::redirect(BASE_URL . "post/detail?pid=" . $post["pid"]);
    }
}