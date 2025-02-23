<?php
require_once "../database/config.php";
require_once "../classes/session.php";

use classes\session\Blogs;

$db = new Database();
$conn = $db->connect();
$blogs = new Blogs($conn);
$Posts = $blogs->show_post();

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post_id = $_POST["post-id"];
    $edited_content = $_POST["edited-content"];
    if ($blogs->edit_post($post_id, $edited_content)) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit();
    }
}
