<?php

namespace classes\user;

class User
{


    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetchUsers(): array|null
    {
        $sql = "SELECT* FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }
    public function fetchUser($name): array|bool|self
    {
        $sql = "SELECT* FROM users WHERE user_name=:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $name);
        $stmt->execute();
        $users = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $users;
    }





    public function register($name, $password, $email): array|bool
    {

        $users = $this->fetchUsers();
        foreach ($users as $user) {
            if ($user["user_name"] === htmlspecialchars($name)) {
                return false;
            }
        }
        $name = htmlspecialchars($name);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = htmlspecialchars($email);

        $sql = "INSERT into users(user_name,user_password,user_email)
        VALUES(:username,:password,:email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $name);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function login($name, $password): bool
    {
        $name = htmlspecialchars($name);


        $sql = "SELECT * FROM users WHERE user_name=:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $name);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user["user_password"])) {
            return true;
        } else {
            return false;
        }
    }
}
