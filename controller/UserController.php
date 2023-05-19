<?php

class UserController
{

    public static function showLoginForm(): void
    {
        if (empty($_SESSION["user"])) {
            ViewHelper::render("view/users/user-login-form.php");
        } else {
            ViewHelper::redirect(BASE_URL . "home/home-page.php");
        }
    }
}