<?php

class User
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }
}