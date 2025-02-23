<?php

namespace classes\session;



class Session
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }



    public function session_props($session_id)
    {



        $sql = "SELECT * FROM users 
        Where user_id=$session_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}



class Blogs extends Session
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_categories(): array|null
    {
        $sql = "SELECT * from blog_categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create_post($title, $content, $category_id, $user_id): bool
    {
        $sql = "INSERT INTO blogs(title,content,category_id,user_id)
        VALUES(:title,:post,$category_id,$user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":post", $content);
        return $stmt->execute();
    }


    public function show_post(): array|null
    {
        $sql = "SELECT  blogs.*,users.user_name,blog_categories.category_name
         FROM blogs
         JOIN users on users.user_id=blogs.user_id
         JOIN blog_categories on blog_categories.category_id=blogs.category_id
         ORDER BY blogs.publish_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete_post($post_id): bool
    {
        $sql = "DELETE FROM blogs
    WHERE :content_id=content_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":content_id", $post_id);
        return $stmt->execute();
    }
    public function edit_post($post_id, $content): bool
    {
        $sql = "UPDATE blogs
        SET content=:content
    WHERE content_id=:content_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":content_id", $post_id);
        $stmt->bindParam(":content", $content);
        return $stmt->execute();
    }




    public function create_comment($comment_text, $user_id, $content_id): bool
    {
        $sql = "INSERT into blogs_comments(comment_text,user_id,content_id)
    VALUES(:comment_text,$user_id,:blog_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":comment_text", $comment_text);
        $stmt->bindParam(":blog_id", $content_id);
        return $stmt->execute();
    }

    public function show_comments(): array
    {
        $sql = "SELECT users.user_name,users.user_id,blogs.content_id,blogs_comments.comment_text,blogs_comments.comment_id,blogs_comments.posting_date
        FROM blogs_comments
        JOIN users on users.user_id=blogs_comments.user_id
        JOIN blogs on blogs.content_id=blogs_comments.content_id
        ORDER BY blogs_comments.posting_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete_comment($comment_id): bool
    {
        $sql = "DELETE from blogs_comments
    WHERE :comment_id=comment_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":comment_id", $comment_id);
        return  $stmt->execute();
    }

    public function comment_length($content_id): array|null
    {
        $sql = "SELECT blogs.content_id, COUNT(comment_id) as comment_count
         from blogs
         JOIN blogs_comments on blogs_comments.content_id=blogs.content_id
         WHERE blogs.content_id=:content_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':content_id', $content_id, \PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $count ? $count : null;
    }

    public function check_status($user_id, $content_id, $status): bool|null
    {

        if ($status == "like" || $status == "dislike") {
            $sql = "SELECT * FROM blogs_status
    WHERE content_id=:content_id and user_id=:user_id and status=:status ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":content_id", $content_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $exists = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $exists ? true : false;
        }
        return null;
    }


    public function post_like($user_id, $content_id, $status): bool|null
    {
        $status = "like";
        $exists = $this->check_status($user_id, $content_id, $status);

        if (!$exists) {
            $sql = "INSERT INTO blogs_status(status,like_counter,content_id,user_id)
        VALUES(:status,1,:content_id,:user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":content_id", $content_id);
            return $stmt->execute();
        } else {
            $sql = "DELETE from blogs_status 
            WHERE user_id = :user_id AND content_id = :content_id AND status=:status";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":content_id", $content_id);
            return $stmt->execute();
        }
    }


    public function post_dislike($user_id, $content_id, $status): bool|null
    {
        $status = "dislike";
        $exists = $this->check_status($user_id, $content_id, $status);

        if (!$exists) {
            $sql = "INSERT INTO blogs_status(status,dislike_counter,content_id,user_id)
        VALUES(:status,1,:content_id,:user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":content_id", $content_id);
            return $stmt->execute();
        } else {
            $sql = "DELETE from blogs_status 
            WHERE user_id = :user_id AND content_id = :content_id AND status=:status";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":content_id", $content_id);
            return $stmt->execute();
        }
    }

    public function show_status($content_id): array|bool
    {
        $sql = "SELECT content_id, sum(like_counter)AS likes
        ,sum(dislike_counter)AS dislikes
         FROM blogs_status
         where content_id=:content_id
         GROUP BY content_id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":content_id", $content_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
