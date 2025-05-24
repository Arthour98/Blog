<?php

namespace classes\gallery;


class Gallery
{

    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Insert_image($image, $user_id)
    {
        $sql = "INSERT into gallery(user_id,image_name)VALUES(:user_id,:image_name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":image_name", $image);
        return $stmt->execute();
    }

    public function Gallery_view()
    {
        $sql = "SELECT * FROM gallery
        LEFT JOIN users ON gallery.user_id = users.user_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function Delete_image($image_id)
    {
        $sql = "DELETE from gallery where image_id=:image_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":image_id", $image_id);
        return $stmt->execute();
    }
    public function comment($image_id, $user_id, $text)
    {
        $sql = "INSERT into gallery_comments(user_id,image_id,comment_text)VALUES
        (:user_id,:image_id,:text)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":user_id", $user_id);
        return $stmt->execute();
    }
    public function getComments()
    {
        $sql = "SELECT * FROM gallery_comments
        JOIN users
        ON users.user_id=gallery_comments.user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getExistingStatus($user_id, $image_id, $status)
    {
        $sql = "SELECT 
        EXISTS(SELECT 1 FROM gallery_likes
        WHERE user_id=:user_id AND image_id=:image_id)as likes,
        EXISTS(SELECT 1 FROM gallery_dislikes
        WHERE user_id=:user_id AND image_id=:image_id)as dislikes";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $status = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $status ?: [];
    }
    public function statusApply($user_id, $image_id, $status)
    {
        $existingStatus = $this->getExistingStatus($user_id, $image_id, $status);
        $existingLike = $existingStatus["likes"];
        $existingDislike = $existingStatus["dislikes"];

        if ($status === "likes") {
            if ($existingLike) {
                $sql = "DELETE FROM gallery_likes 
                WHERE user_id=:user_id AND image_id=:image_id";
            } elseif ($existingDislike) {
                $sql = "DELETE FROM gallery_dislikes
                WHERE user_id=:user_id AND image_id=:image_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id',  $user_id, \PDO::PARAM_INT);
                $stmt->bindParam(':image_id', $image_id, \PDO::PARAM_INT);
                $stmt->execute();

                $sql = "INSERT INTO gallery_likes (user_id, image_id, likes)
          VALUES (:user_id, :image_id, 1)";
            } else {
                $sql = "INSERT INTO gallery_likes (user_id, image_id, likes)
          VALUES (:user_id, :image_id, 1)";
            }
        } elseif ($status === "dislikes") {
            if ($existingLike) {
                $sql = "DELETE FROM gallery_likes
                WHERE user_id=:user_id AND image_id=:image_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id',  $user_id, \PDO::PARAM_INT);
                $stmt->bindParam(':image_id', $image_id, \PDO::PARAM_INT);
                $stmt->execute();

                $sql = "INSERT INTO gallery_dislikes (user_id, image_id, dislikes)
          VALUES (:user_id, :image_id, 1)";
            } elseif ($existingDislike) {
                $sql = "DELETE FROM gallery_dislikes
                WHERE user_id=:user_id AND image_id=:image_id";
            } else {
                $sql = "INSERT INTO gallery_dislikes (user_id, image_id, dislikes)
            VALUES (:user_id, :image_id, 1)";
                $stmt = $this->conn->prepare($sql);
            }
        } else {
            return false;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id',  $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':image_id', $image_id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getLikes($image_id)
    {
        $sql = "SELECT 
       COUNT(likes) as likes
       FROM gallery_likes
       WHERE image_id=:image_id 
       group by likes";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }
    public function getDislikes($image_id)
    {
        $sql = "SELECT 
       COUNT(dislikes) as dislikes
       FROM gallery_dislikes
       WHERE image_id=:image_id 
       group by dislikes";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }
}
