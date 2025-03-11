<?php
require_once "database/config.php";
require_once "classes/session.php";

use classes\session\Session;
use classes\session\Blogs;


$db = new Database();
$conn = $db->connect();

session_start();

$session = new Session($conn);
$blogs = new Blogs($conn);

$Posts = $blogs->show_post();
$comments = $blogs->show_comments();
$categories = $blogs->read_categories();

$comment_count = [];
foreach ($Posts as $Post) {
    $content_id = $Post["content_id"];
    $comment_count[$content_id] = $blogs->comment_length($content_id);
}
$status_count = [];
foreach ($Posts as $Post) {
    $content_id = $Post["content_id"];
    $status_count[$content_id] = $blogs->show_status($content_id);
}

if (isset($_SESSION["user_id"])) {

    $user = $session->session_props($_SESSION["user_id"]);


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["POST-BLOG"])) {
        $title = $_POST["title"];
        $content = $_POST["post"];
        $category_id = $_POST["category"];
        $user_id = $user["user_id"];

        if ($blogs->create_post($title, $content, $category_id, $user_id)) {
            header("location:index.php");
            $_SESSION["successMessage"] = "Your Post Created Successfully";
            exit();
        } else {
            header("location:index.php");
            $_SESSION["errorMessage"] = "Error";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["POST-COMMENT"]) && !empty($_POST["comment_text"])) {
        $comment_text = $_POST["comment_text"];
        $blog_id = $_POST["blog_id"];
        $user_id = $user["user_id"];
        if ($blogs->create_comment($comment_text, $user_id, $blog_id)) {
            header("location:index.php");
            $_SESSION["successMessage"] = "Comment Added";
            exit();
        } else {
            header("location:index.php");
            $_SESSION["successMessage"] = "Error";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["REMOVE-COMMENT"])) {
        $comment_id = $_POST["comment_id"];
        if ($blogs->delete_comment($comment_id)) {

            header("location:index.php");
            $_SESSION["successMessage"] = "Comment Deleted";
            exit();
        } else {
            header("location:index.php");
            $_SESSION["successMessage"] = "Error";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["DELETE-POST"])) {
        $post_id = $_POST["post_id"];
        if ($blogs->delete_post($post_id)) {
            header("location:index.php");
            $_SESSION["successMessage"] = "Post Deleted";
            exit();
        } else {
            header("location:index.php");
            $_SESSION["successMessage"] = "Error";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {


        if (isset($_POST["submit_like"])) {
            $status = $_POST["status"];
            $content_id = $_POST["content_id"];
            $user_id = $_POST["user_id"];
            $blogs->post_like($user_id, $content_id, $status);
            header("location:index.php");
            exit();
        } elseif (isset($_POST["submit_dislike"])) {
            $status = $_POST["status"];
            $content_id = $_POST["content_id"];
            $user_id = $_POST["user_id"];
            $blogs->post_dislike($user_id, $content_id, $status);
            header("location:index.php");
            exit();
        }
    }


    $successMessage = "";
    $errorMessage = "";
}
?>
<?php include_once "includes/header.php"; ?>
<?php if (!empty($_SESSION["successMessage"])): ?>
    <div class="container absolute-center mt-3  ">
        <div class=" alert alert-success alert-dismissible fade show " id="alert" role="alert">
            <p class="text-center"><?php echo $_SESSION["successMessage"]; ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    </div>
    <?php unset($_SESSION['successMessage']); ?>
<?php endif; ?>

<div class="container-fluid m-0 p-0 ">
    <div class="row height-fill">
        <!--filtro col-->
        <?php if (isset($user)): ?>
            <div class="filter-col col-xxl-2 col-xl-4  col-lg-4  col-md-5 col-sm-12  p-0 text-light">
                <div class="blog-filter d-flex flex-column justify-content-end  row-gap-20 p-5 ">
                    <h3>Search
                        <div class="option d-flex ">
                            <form action="index.php" method="post">
                                <div class="d-flex  gap-20">
                                    <input type="search" name="search" class="form-control">
                                    <input type="submit" value="Search" class="btn btn-primary rounded">
                                </div>
                            </form>
                        </div>
                        <h3>
                            Choose Category
                        </h3>
                        <form method="post" action="index.php" class="d-flex flex-column row-gap-20">
                            <?php foreach ($categories as $category): ?>
                                <div class="option d-flex flex-100 align-items center gap-5">
                                    <input type="checkbox" name="category"
                                        class="category-input"
                                        value="<?php echo $category["category_name"]; ?>">
                                    <label class="form-check-control text-break fs-5"><?php echo $category["category_name"]; ?></label>
                                </div>
                            <?php endforeach; ?>
                            <div class="option d-flex gap-20">
                                <button type="submit" id="filter" name="filter_category" class="btn btn-primary align-self-end ">FILTER</button>
                                <button type="submit" id="reset" name="reset_category" class="btn btn-primary ">RESET</button>
                            </div>

                        </form>

                </div>
            </div>
        <?php endif; ?>
        <!--telos filtrou-->

        <?php if (isset($_SESSION["user_id"])): ?>
            <div class=" col-xxl-8 col-xl-8 col-lg-7  col-md-6 col-sm-12  px-5 pt-5 ">
            <?php else: ?>
                <div class=" col-xxl-12 col-xl-12 col-lg-12  col-md-12 col-sm-12  px-5 pt-5 ">
                <?php endif; ?>
                <!-- block gia dhmiougeia enos POST ean uparxei sundedemenos xrhsths-->
                <?php if (isset($_SESSION["user_id"])): ?>
                    <div class="create-post">
                        <button type="button" id="create-post" class="btn btn-primary rounded-4">
                            <i class="fa-solid fa-square-plus"></i>
                            Create Post
                        </button>
                        <button type="button" class="btn btn-danger rounded-4 mt-3" id="cancel-post">Cancel</button>
                    </div>
                    <!-- forma dhmiourgias blog -->
                    <?php include "includes/post-creation.php"; ?>
                    <!----->
                <?php endif; ?>

                <!--olo to code tou content se mia gramh-->
                <?php include "includes/post.php"; ?>
                <!---->

                </div>
            </div>
    </div>
    <?php include_once "includes/footer.php" ?>