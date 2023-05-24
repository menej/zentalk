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

    public static function insert(mixed $uid, mixed $title, mixed $content)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO post (uid, title, content) 
            VALUES (:uid, :title, :content)");
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":content", $content);

        $statement->execute();
    }

    public static function update(mixed $pid, mixed $title, mixed $content)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE post SET title = :title, content = :content 
            WHERE pid = :pid");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":content", $content);
        $statement->bindParam(":pid", $pid, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function delete(mixed $pid): void
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM post WHERE pid = :pid");
        $statement->bindParam(":pid", $pid, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function getFiveLatest()
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT pid, uid, title, content, rating 
            FROM post
            ORDER BY post_date DESC
            LIMIT 5;
        ");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllByTitle($query)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT pid, uid, title, content, rating
            FROM post
            WHERE title LIKE :title
        ");
        $str = '%' . $query . '%';
        $statement->bindParam(":title", $str);
        $statement->execute();

        return $statement->fetchAll();
    }
}