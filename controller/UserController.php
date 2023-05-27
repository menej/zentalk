<?php

require_once("model/FavouriteDB.php");
require_once("model/PostDB.php");
require_once("model/UserDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class UserController
{
    // GET: user/login
    public static function showLoginForm($data = [], $errors = []): void
    {
        // Check if user is logged in
        if (User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "username" => "",
                "password" => ""
            ];
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        // Note: at this point $data is not used
        $vars = ["data" => $data, "errors" => $errors];

        ViewHelper::render("view/users/user-login-form.php", $vars);
    }

    // POST: user/login
    public static function login()
    {
        // TODO: password checking might not be the best (what did I mean by that?)
        $rules = [
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,
            "password" => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["username"] = empty($data["username"]) ? "Provide the username." : "";
        $errors["password"] = empty($data["password"]) ? "Provide the password." : "";

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            if (UserDB::validLoginAttempt($data["username"], $data["password"])) {
                User::loginUser($data["username"]);
                ViewHelper::redirect(BASE_URL . "home");
            } else {
                self::showLoginForm($data, [
                    "errorMessage" => "Invalid username or password.",
                    "username" => "",
                    "password" => ""
                ]);
            }
        } else {
            self::showLoginForm($data, $errors);
        }
    }

    public static function logout()
    {
        unset($_SESSION["user"]);
        ViewHelper::redirect(BASE_URL . "home");
    }

    public static function showRegisterForm($data = [], $errors = [])
    {
        // Check if user is logged in
        if (User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "email" => "",
                "username" => "",
                "password" => "",
                "first_name" => "",
                "last_name" => ""
            ];
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["data" => $data, "errors" => $errors];

        ViewHelper::render("view/users/user-register-form.php", $vars);
    }

    // POST: user/register
    public static function register()
    {
        // TODO: implement validation on frontend (JS - red borders, regex for password) and HTML pattern regex
        // check for validity
        /*$rules = [
            "email" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than... (256 chars)
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than... (25 chars)
            "password" => FILTER_SANITIZE_SPECIAL_CHARS,  // cannot be longer than... (72 chars)
            "first_name" => FILTER_SANITIZE_SPECIAL_CHARS, // cannot be longer than... (50 chars)
            "last_name" => FILTER_SANITIZE_SPECIAL_CHARS  // cannot be longer than... (50 chars)
        ];
        */
        $rules = [
            "email" => [
                "filter" => FILTER_VALIDATE_EMAIL & FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^.{1,256}$/"]
            ],
            "username" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-Z0-9šđčćžŠĐČĆŽ]{1,25}$/"]
            ],
            "password" => [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) {
                    $uppercase = preg_match('@[A-Z]@', $value);
                    $lowercase = preg_match('@[a-z]@', $value);
                    $number = preg_match('@[0-9]@', $value);
                    $specialChars = preg_match('@[\W]@', $value);
                    return (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($value) <= 8 || strlen($value) >= 72) ? false : $value;
                }
            ],
            "first_name" => [
                // Only letters, dots, dashes
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^[a-zA-ZšđčćžŠĐČĆŽ\.\-]{1,50}$/']
            ],
            "last_name" => [
                // Only letters, dots, dashes
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^[a-zA-ZšđčćžŠĐČĆŽ\.\-]{1,50}$/']
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);


        //$errors["email"] = $data["email"] === false ? "Provide an valid email" : "";
        $errors["email"] = $data["email"] === false ? "Provide an valid email" : "";
        $errors["username"] = $data["username"] === false ? "Provide an valid username (username should contain no special characters, max. length of 25)" : "";
        $errors["password"] = $data["password"] === false ? "Provide an valid password" : "";
        $errors["first_name"] = $data["first_name"] === false ? "Provide an valid first name" : "";
        $errors["last_name"] = $data["last_name"] === false ? "Provide an valid last name" : "";

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
        UserDB::insert(
            $data["email"],
            $data["username"],
            $data["password"],
            $data["first_name"],
            $data["last_name"]
        );

        // login the user into the session
        // this will work, since the variables $_POST["username"] and $_POST["password"] are set and correct
        self::login();
    }

    public static function profile()
    {
        ViewHelper::redirect(BASE_URL . "home");
    }
}