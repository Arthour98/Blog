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
    $image_id = $data["image_id"];
    $likes = $gallery->getLikes($image_id) ?: ["likes" => 0];
    $dislikes = $gallery->getDislikes($image_id) ?: ["dislikes" => 0];
    $response = array_merge($likes, $dislikes);
    if (!empty($response)) {
        echo json_encode($response);
        exit;
    } else {
        echo json_encode([
            "likes" => 0,
            "dislikes" => 0
        ]);
        exit;
    }
}
