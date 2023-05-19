<?php

class HomeController
{
    // Show home page (GET: index)
    public static function index()
    {
        ViewHelper::render("view/home/home-page.php");
    }
}