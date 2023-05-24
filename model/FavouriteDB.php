<?php

require_once "DBInit.php";

class FavouriteDB
{
    public static function getFavourites(int $uid): array
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT fid, uid, pid
            FROM favourite
            WHERE uid = :uid
        ");

        $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function addFavourite(mixed $uid, mixed $pid)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO favourite (uid, pid) 
            VALUES (:uid, :pid)
        ");
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":pid", $pid);

        $statement->execute();
    }

    public static function favouriteExists(int $pid, int $uid): bool
    {
        $dbh = DBInit::getInstance();

        $query = "
            SELECT COUNT(fid) 
            FROM favourite 
            WHERE pid = :pid AND uid = :uid
        ";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":pid", $pid);
        $stmt->bindParam(":uid", $uid);

        $stmt->execute();

        return $stmt->fetchColumn(0) == 1;
    }

    public static function removeFavourite(mixed $uid, mixed $pid)
    {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("DELETE FROM favourite WHERE pid = :pid AND uid = :uid");
        $stmt->bindParam(":pid", $pid);
        $stmt->bindParam(":uid", $uid);

        $stmt->execute();
    }

}