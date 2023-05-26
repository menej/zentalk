<?php

require_once "UserDB.php";

class User
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }

    public static function loginUser(mixed $username)
    {
        try {
            $user = UserDb::getUserByUsername($username);
        } catch (InvalidArgumentException $ex) {
            return false;
        }

        $_SESSION["user"] = $user;
        return $user;
    }
}