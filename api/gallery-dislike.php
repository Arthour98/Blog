<?php require_once __DIR__ . "/../database/config.php";
require_once __DIR__ . "/../classes/gallery.php";

use classes\gallery\Gallery;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$db = new Database();
$conn = $db->connect();
$gallery = new Gallery($conn);



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $data["user_id"];
    $image_id = $data["image_id"];
    $status = $data["status"];
    $gallery->statusApply($user_id, $image_id, $status);
    $likes = $gallery->getLikes($image_id) ?: ["likes" => 0];
    $dislikes = $gallery->getDislikes($image_id) ?: ["dislikes" => 0];
    $response = array_merge($likes, $dislikes);

    echo json_encode($response);
    exit;
}
