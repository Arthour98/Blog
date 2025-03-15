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
}
