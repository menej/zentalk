<?php

require_once "controller/UserController.php";
require_once "controller/PostController.php";
require_once "controller/CommentController.php";
require_once "controller/FavouriteController.php";
require_once "controller/HomeController.php";
require_once "ViewHelper.php";

session_start();

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");  //noispection Duplicate character
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

// define("INC_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "view/inc/");
const INC_URL = "view/inc/";  // TODO: find out why above method for this does not work

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";


$urls = [
    "home" => function () {
        HomeController::index();
    },
    "user" => function () {
        UserController::login();
    },
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::showLoginForm();
        }
    },
    "user/register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        } else {
            UserController::showRegisterForm();
        }
    },
    "user/favorites" => function () {

    },
    "user/profile" => function() {
        UserController::profile();
    },
    "post" => function () {
        PostController::index();
    },
    "post/search" => function () {
        PostController::search();
    },
    "post/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::add();
        } else {
            PostController::showAddForm();
        }
    },
    "post/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::edit();
        } else {
            PostController::showEditForm();
        }
    },
    "post/delete" => function () {
        PostController::delete();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "home");
    }
];


try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
        // ViewHelper::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
}