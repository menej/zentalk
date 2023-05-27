<?php

require_once "controller/UserController.php";
require_once "controller/PostController.php";
require_once "controller/CommentController.php";
require_once "controller/FavouriteController.php";
require_once "controller/HomeController.php";
require_once "ViewHelper.php";

session_start();

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

// TODO: find out why the commented out method for this does not work
// define("INC_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "view/inc/");
const INC_URL = "view/inc/";

// Check if URL contains path
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";


$urls = [
    "home" => function () {
        // [GET, POST]: home
        HomeController::index();
    },
    "user" => function () {
        // [GET, POST]: user
        ViewHelper::redirect(BASE_URL . "user/profile");
    },
    "user/login" => function () {
        // POST: user/login
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } // GET: user/login
        else {
            UserController::showLoginForm();
        }
    },
    "user/register" => function () {
        // POST: user/register
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        }  // GET: user/register
        else {
            UserController::showRegisterForm();
        }
    },
    "user/favourites" => function () {
        FavouriteController::favourites();
    },
    "user/favourites/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            FavouriteController::addFavourite();
        } else {
            ViewHelper::redirect(BASE_URL . "home");
        }
    },
    "user/favourites/remove" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            FavouriteController::removeFavourite();
        }
    },
    "user/logout" => function () {
        UserController::logout();
    },
    "user/profile" => function () {
        UserController::profile();
    },
    "post" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ViewHelper::redirect(BASE_URL . "home");
        } else {
            PostController::search();
        }
    },
    "post/detail" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ViewHelper::redirect(BASE_URL . "home");
        } else {
            PostController::index();
        }
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::delete();
        } else {
            PostController::showDeleteForm();
        }
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "home");
    }
];


try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        // echo "No controller for '$path'";
        ViewHelper::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
}