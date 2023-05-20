<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController
{

    public static function showLoginForm($data = [], $errors = []): void
    {
        // Check if user is logged in
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
            $_SESSION["user"] = UserDB::getUserByUsername($_POST["username"]);

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

    public static function showRegisterForm($data = [], $errors = [])
    {
        // Check if user is logged in
        if (!empty($_SESSION["user"])) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // Show register form
        if (empty($errors)) {
            $errors = [
                "username" => "",
                "password" => "",
                "email" => "",
                "first_name" => "",
                "last_name" => ""
            ];
        }

        $vars = ["errors" => $errors];

        ViewHelper::render("view/users/user-register-form.php", $vars);
    }

    // POST: user/register
    public static function register()
    {
        // check for validity
        $rules = [
            "email" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than...
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than...
            "password" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than... (72 chars)
            "first_name" => FILTER_SANITIZE_SPECIAL_CHARS, // cannot be longer than...
            "last_name" => FILTER_SANITIZE_SPECIAL_CHARS  // cannot be longer than...
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["email"] = empty($data["email"]) ? "Provide email" : "";
        $errors["username"] = empty($data["username"]) ? "Provide username" : "";
        $errors["password"] = empty($data["password"]) ? "Provide password" : "";
        $errors["first_name"] = empty($data["first_name"]) ? "Provide first name" : "";
        $errors["last_name"] = empty($data["last_name"]) ? "Provide last name" : "";
        $errors["error_message"] = "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        // check if data is valid
        if (!$isDataValid) {
            self::showRegisterForm($data, $errors);
            return;
        }

        // check if username exists in DB
        if (UserDB::usernameExists($data["username"])) {
            $errors["error_message"] = "Username already taken";
            self::showRegisterForm($data, $errors);
            return;
        }

        // check if email exists
        if (UserDB::emailExists($data["email"])) {
            $errors["error_message"] = "Email already taken";
            self::showRegisterForm($data, $errors);
            return;
        }

        // create user
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        UserDB::insert(
            $data["email"],
            $data["username"],
            $data["password"],
            $data["first_name"],
            $data["last_name"]
        );


        // login the user into the session
        self::login();
    }
}