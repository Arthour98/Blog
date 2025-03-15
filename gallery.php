<?php require_once "database/config.php" ?>
<?php require_once "classes/session.php" ?>
<?php require_once "classes/gallery.php" ?>
<?php

use classes\session\Session;
use classes\gallery\Gallery;

$db = new Database();
$conn = $db->connect();
$user =  null;
session_start();

$session = new Session($conn);
$gallery = new Gallery($conn);
$images = $gallery->Gallery_view();


if (isset($_SESSION["user_id"])) {

    $GLOBALS["user"]  = $session->session_props($_SESSION["user_id"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $image_name = $_FILES["add_image"];
        $user_id = $user["user_id"];

        $image_folder =  "images/";
        $image_file = $image_folder . basename($_FILES["add_image"]["name"]);
        if (!file_exists($image_folder)) {
            mkdir($image_folder, 0777, true);
        }
        if (move_uploaded_file($_FILES["add_image"]["tmp_name"], __DIR__ . "/" . $image_file)) {
            $gallery->Insert_image($image_file, $user_id);
            header("location:gallery.php");
            return;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $image_id = $_POST["image_id"];
        if ($gallery->delete_image($image_id)) {
            $_SESSION["successMessage"] = "Image Deleted Successfully";
            header("location:gallery.php");
            exit();
        }
    }
}




?>


<?php include_once "includes/header.php" ?>
<h1 class="text-center py-4">SHARE YOUR MOMENTS</h1>
<main class="gallery d-flex flex-100">
    <div class="gallery-menu">

        <i class="fa-solid fa-bars cursor-pointer fs-1 menu-icon "></i>

        <div class="btn-group-vertical w-0 h-25" id="menu-options">
            <button type="button" class="btn btn-primary border border-bottom border-dark add-image">Add-image</button>
            <button type="button" class="btn btn-primary border border-bottom border-dark delete-image">Delete-image</button>
            <button type="button" class="btn btn-primary border border-bottom border-dark edit-image">Edit-image</button>
            <button type="button" class="btn btn-primary border border-bottom border-dark view-image">View-images</button>
        </div>

        <div class="modification-container d-none ">
            <!------Adding mod ----------->
            <div class="adding-container w-100 flex-100 gap-2 d-none">
                <div class="border border-1 border-dark rounded-4 w-100 flex-50" id="add-placeholder">
                    <img src="" class="img-fluid rounded-4 h-100" id="image-for-adding">
                </div>

                <form id=" add_image" action="gallery.php"
                    method="post" enctype="multipart/form-data"
                    class="d-flex w-50 justify-content-between align-items-center
                    ">
                    <label for="Upload" class="d-flex flex-column position-relative align-items-center
                " id="label-upload">
                        <input type="file" name="add_image"
                            id="image-input" class="position-absolute cursor-pointer h-100">
                        <i class="fa-solid fa-circle-arrow-up upload-icon text-primary "></i>
                    </label>
                    <input type="submit" value="ADD" id="submit-image"
                        class="btn btn-primary">
                </form>
            </div>
            <!---------Delete mod ----------->
            <div class="delete-container w-100 flex-100 gap-1 d-none">
                <div class="border border-1 border-dark rounded-4 w-100 flex-50" id="delete-placeholder">

                </div>

                <form id="delete_image" action="gallery.php"
                    method="post" enctype="multipart/form-data"
                    class="d-flex w-100 justify-content-center align-items-center">
                    <input type="hidden" name="image_id" value="">
                    <input type="submit" value="DELETE" class="btn btn-danger" id="delete_image">
                </form>

            </div>

        </div>
    </div>





    <div class=" container-sm border border-1 border-light rounded-5" id="gallery-container">
        <?php foreach ($images as $image): ?>
            <div class="row justify-content-center my-5 ">
                <div class="col-8 card h-100 p-0 m-0 "
                    data-bs-toggle="offcanvas" data-bs-target="#commentary">
                    <div class="header px-2 italic"><?php echo $image["user_name"] ?></div>
                    <div class="body">
                        <img src="<?php echo "./" . $image["image_name"] ?>"
                            id="image-<?php echo $image["image_id"]; ?>"
                            data-image-id="<?php echo $image["image_id"]; ?>"
                            class="gallery-images" <?php if (!($user !== null  && $image["user_id"] === $user["user_id"])): ?>
                            draggable="false"
                            <?php else:  ?>draggable="true"
                            <?php endif; ?>>

                    </div>
                    <div class="commentary px-2"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <div class="gallery-panel">
        <div class="offcanvas offcanvas-end w-25 bg-dark text-light " id="commentary">
            <button type="button" class="btn-close text-reset  "
                data-bs-dismiss="offcanvas"></button>
            <div class="offcanvas-header d-flex flex-column">
                <h2 class="offcanvas-title align-center">Panel</h1>
                    <img src="" id="target-image" class="img-fluid">

            </div>

            <div class="offcanvas-body d-flex flex-column row-gap-20">
                <div class="d-flex gap-20 ps-5">
                    <form action="gallery.php" method="POST">
                        <input type="hidden" name="image_id" id="like-input">
                        <input type="hidden" name="status" value="like">
                        <button type="submit" name="submit_like" class="like">
                            <i class="fa-solid fa-thumbs-up fs-3"></i>
                        </button>
                    </form>
                    <form action="gallery.php" method="POST">
                        <input type="hidden" name="image_id" id="dislike-input">
                        <input type="hidden" name="status" value="dislike">
                        <button type="submit" name="submit_dislike" class="dislike">
                            <i class="fa-regular fa-thumbs-down fs-3"></i>
                        </button>
                    </form>
                </div>

                <div id="target-comments" class="d-flex flex-column 
                 gap-2 px-5 ">
                    <h2 class="text-decoration-underline" id="comment_count">Comments:</h2>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <p>dadadadadadasdad</p>
                    <h5 id="toggle-comments" class="text-decoration-underline cursor-pointer">Show more</h5>
                    <form action="gallery.php" method="post" class="form-control bg-dark">
                        <textarea class="form-control mt-3" id="comment-area">
                        </textarea>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="rounded-3 mt-3 bg-success value=" value="comment" name="comment">
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>


</main>


<?php include_once "includes/footer.php" ?>