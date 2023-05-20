<?php

require_once "DBInit.php";

class UserDB
{

    public static function validLoginAttempt(mixed $username, mixed $password): bool
    {
        /*
        $dbh = DBInit::getInstance();
        $query = "SELECT COUNT(uid) FROM user WHERE username = :username AND password = :password";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":username", $username);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $password_hash);

        $stmt->execute();
        return $stmt->fetchColumn(0) == 1;
        */
        $dbh = DBInit::getInstance();
        $query = "SELECT password FROM user WHERE username = :username";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $db_password = $stmt->fetchColumn();

        return password_verify($password, $db_password);
    }

    public static function getUser($uid)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT uid, username, password, email, first_name, last_name, reg_date 
            FROM user 
            WHERE uid = :uid
        ");
        $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
        $statement->execute();

        $user = $statement->fetch();

        if ($user != null) {
            return $user;
        } else {
            throw new InvalidArgumentException("No record with id $uid");
        }
    }

    public static function getUserByUsername(mixed $username)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT uid, username, password, email, first_name, last_name, reg_date 
            FROM user 
            WHERE username = :username
        ");
        $statement->bindParam(":username", $username);
        $statement->execute();

        $user = $statement->fetch();

        if ($user != null) {
            return $user;
        } else {
            throw new InvalidArgumentException("No record with id $username");
        }
    }

    public static function usernameExists(string $username): bool
    {
        $dbh = DBInit::getInstance();

        $query = "SELECT COUNT(uid) FROM user WHERE username = :username";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":username", $username);

        $stmt->execute();

        return $stmt->fetchColumn(0) == 1;
    }

    public static function emailExists(string $email): bool
    {
        $dbh = DBInit::getInstance();

        $query = "SELECT COUNT(uid) FROM user WHERE email = :email";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        return $stmt->fetchColumn(0) == 1;
    }

    public static function insert(string $email, string $username, string $password, string $first_name, string $last_name): void
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO user (email, username, password, first_name, last_name) 
            VALUES (:email, :username, :password, :first_name, :last_name)
        ");
        $statement->bindParam(":email", $email);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":first_name", $first_name);
        $statement->bindParam(":last_name", $last_name);

        $statement->execute();
    }

}