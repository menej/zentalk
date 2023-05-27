<?php

require_once("model/PostDB.php");
require_once("model/UserDB.php");
require_once("model/FavouriteDB.php");

require_once("ViewHelper.php");

class PostController
{
    // GET: post/detail
    public static function index()
    {
        // Get details of a specific post
        if (isset($_GET["pid"])) {
            $pid = filter_input(INPUT_GET, "pid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if the post exists
            try {
                $post = PostDB::get($pid);
            } catch (Exception $ex) {
                ViewHelper::error404();
                exit;
            }

            $op = UserDB::getUser($post["uid"]);
            $post["op"] = $op;

            $isFavourite = false;
            if (User::isLoggedIn()) {
                $isFavourite = FavouriteDB::favouriteExists($post["pid"], $_SESSION["user"]["uid"]);
            }

            ViewHelper::render("view/posts/post-detail.php", ["post" => $post, "isFavourite" => $isFavourite]);

        } // Get list of all posts
        else {
            ViewHelper::redirect(BASE_URL . "post?" . "q=");
        }
    }

    public static function showAddForm($data = [], $errors = [])
    {
        // check if user is logged in, else redirect him to login
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            exit();
        }

        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "title" => "",
                "content" => ""
            ];
        }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["post" => $data, "errors" => $errors];
        ViewHelper::render("view/posts/post-add.php", $vars);

    }

    public static function add()
    {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            exit();
        }

        $rules = [
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "content" => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = empty($data["title"]) ? "Provide the title." : "";
        $errors["content"] = empty($data["content"]) ? "Provide the content." : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            PostDB::insert(
                $_SESSION["user"]["uid"],
                $data["title"],
                $data["content"],
            );

            ViewHelper::redirect(BASE_URL . "home");
        } else {
            echo "invalid";
            self::showAddForm($data, $errors);
        }

    }

    // GET: post/edit
    public static function showEditForm($data = [], $errors = []): void
    {
        // Check if the user is logged in
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            exit();
        }

        $pid = filter_input(INPUT_GET, "pid", FILTER_SANITIZE_NUMBER_INT);

        // Check if the GET request is valid
        if ($pid === null) {
            ViewHelper::error404();
            return;
        }

        // Check if the post exists
        try {
            $post = PostDB::get($pid);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            exit;
        }

        // Check if current added data is empty or not
        if (empty($data)) {
            $data = $post;
        }

        // Fill errors
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        // Check if the current user is the creator of the
        // TODO: implement this in the model
        if ($_SESSION["user"]["uid"] !== $data["uid"]) {
            ViewHelper::redirect(BASE_URL . "home");
            return;
        }

        // User is the creator and everything else is valid
        ViewHelper::render("view/posts/post-edit.php", ["post" => $data, "errors" => $errors]);
    }

    // POST: post/edit
    public static function edit()
    {
        // TODO: check if all these checking procedures make sense, and if so - make a function for checking these
        // Check if user is logged in
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }
        $pid = filter_input(INPUT_POST, "pid", FILTER_SANITIZE_NUMBER_INT);

        // Check if the GET request is valid
        if ($pid === null) {
            ViewHelper::error404();
            return;
        }

        // Check if the post exists
        try {
            $post = PostDB::get($pid);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            exit;
        }

        // TODO: implement this in the model (same as showEditForm)
        // Check if the current user is the creator of the
        if ($_SESSION["user"]["uid"] !== $post["uid"]) {
            echo "here";
            ViewHelper::redirect(BASE_URL . "home");
            exit();
        }

        $rules = [
            "pid" => FILTER_SANITIZE_NUMBER_INT,
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "content" => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = empty($data["title"]) ? "Provide the title." : "";
        $errors["content"] = empty($data["content"]) ? "Provide the content." : "";
        $errors["pid"] = empty($data["pid"]) ? "Provide a valid book id." : "";  // What if it's not positive?

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }
        if ($isDataValid) {
            PostDB::update(
                $data["pid"],
                $data["title"],
                $data["content"]
            );
            ViewHelper::redirect(BASE_URL . "post?pid=" . $data["pid"]);
        } else {
            // TODO: this is bad, everything gets checked twice when we call showEditForm
            // TODO: should we even check the data and errors in showEditForm?
            self::showEditForm($data, $errors);
        }
    }

    // GET: post/delete
    public static function showDeleteForm()
    {
        // Check if user is logged in
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }

        $pid = filter_input(INPUT_GET, "pid", FILTER_SANITIZE_NUMBER_INT);

        // Check if the GET request is valid
        if ($pid === null) {
            ViewHelper::error404();
            return;
        }

        // Check if the post exists
        try {
            $post = PostDB::get($pid);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            exit;
        }

        // Check if the current user is the creator of the
        if ($_SESSION["user"]["uid"] !== $post["uid"]) {
            echo "here";
            ViewHelper::redirect(BASE_URL . "home");
            exit();
        }

        $data = $post;

        // Everything is valid
        ViewHelper::render("view/posts/post-delete.php", ["post" => $data]);
    }

    // POST: post/delete
    public static function delete()
    {

        // Check if the user is logged in
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }

        $rules = [
            "pid" => FILTER_VALIDATE_INT
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        // Check if the POST request is valid
        if ($data["pid"] === null) {
            ViewHelper::error404();
            exit();
        }

        // Check if the post exists
        try {
            $post = PostDB::get($data["pid"]);
        } catch (Exception $ex) {
            ViewHelper::redirect(BASE_URL . "home");
            exit;
        }

        // Check if the current user is the creator of the
        if ($_SESSION["user"]["uid"] !== $post["uid"]) {
            ViewHelper::redirect(BASE_URL . "home");
            exit();
        }

        $isDataValid = true;
        if ($isDataValid) {
            PostDB::delete($data["pid"]);
            $url = BASE_URL . "post";
        } else {
            // How could any of these happen?
            if ($data["id"] !== null) {
                $url = BASE_URL . "post/edit?pid=" . $data["pid"];
            } else {
                $url = BASE_URL . "post";
            }
        }

        ViewHelper::redirect($url);
    }

    // GET: post
    public static function search()
    {
        if (isset($_GET["q"])) {
            $query = filter_input(INPUT_GET, "q", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $posts = PostDB::getAllByTitle($query);

            foreach ($posts as &$post) {
                $user = UserDB::getUser($post["uid"]);
                $post["user"] = $user;
            }

            ViewHelper::render("view/posts/post-list.php", ["posts" => $posts, "query" => $query]);
        }
        else {
            self::index();
        }
    }
}