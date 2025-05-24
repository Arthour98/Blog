<?php require_once __DIR__ . "/../database/config.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"), true);
$image_id = $data["image_id"] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $sql = "SELECT  gallery_comments.comments_id,
gallery_comments.comment_text,
gallery.image_id,
gallery.image_name,
users.user_id,
users.user_name
  FROM gallery_comments
    left JOIN users
    ON  gallery_comments.user_id=users.user_id
    left JOIN gallery
    ON  gallery_comments.image_id=gallery.image_id
     WHERE 
    gallery_comments.image_id=:image_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":image_id", $image_id);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($result)) {
    echo json_encode($result);
    exit;
  } else {
    $sql = "SELECT  
gallery.image_id,
gallery.image_name,
users.user_id,
users.user_name
  FROM gallery
    left JOIN users
    ON  gallery.user_id=users.user_id
     WHERE 
    gallery.image_id=:image_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":image_id", $image_id);
    $stmt->execute();
    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result2);
    exit;
  }
}
