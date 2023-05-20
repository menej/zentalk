<?php

require_once "DBInit.php";

class PostDB
{

    public static function get(mixed $id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT pid, uid, title, content, rating, post_date
            FROM post 
            WHERE pid = :id
        ");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $book = $statement->fetch();

        if ($book != null) {
            return $book;
        } else {
            // TODO: catch the error and show 404 page
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getAll(): bool|array
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT pid, uid, title, content, rating 
            FROM post;
        ");
        $statement->execute();

        return $statement->fetchAll();
    }
}