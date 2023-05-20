<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController
{

    public static function showLoginForm($data = [], $errors = []): void
    {
        if (!empty($_SESSION["user"])) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        if (empty($errors)) {
            $errors = [
                "username" => "",
                "password" => "",
                "incorrect" => ""
            ];
        }

        $vars = ["errors" => $errors];

        ViewHelper::render("view/users/user-login-form.php", $vars);
    }

    // POST request
    public static function login()
    {
        if (UserDB::validLoginAttempt($_POST["username"], $_POST["password"])) {
            $_SESSION["user"] = $_POST["username"];

            ViewHelper::redirect(BASE_URL . "home");
        } else {
            //ViewHelper::render("view/user-login-form.php", [
             //   "errorMessage" => "Invalid username or password."
            //]);
            echo "hacker?<br>";
        }
    }

    public static function profile()
    {
        unset($_SESSION["user"]);
        ViewHelper::redirect(BASE_URL . "home");
    }
}