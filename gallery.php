<?php require_once "database/config.php" ?>
<?php require_once "classes/session.php" ?>
<?php

use classes\session\Session;

$db = new Database();
$conn = $db->connect();

session_start();

$session = new Session($conn);

if (isset($_SESSION["user_id"])) {

    $user = $session->session_props($_SESSION["user_id"]);
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

        <div class="modification-container d-none">

            <p>Hello yura</p>

        </div>

    </div>






    <div class="container-sm border border-1 border-light rounded-5" id="gallery-container">
        <div class="row justify-content-center my-5">
            <div class="col-8 card p-0 m-0 ">
                <div class="header px-2">Hello</div>
                <div class="body"><img src="/images/backgound-forum.jpeg"></div>
                <div class="commentary px-2">Goodbye</div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8 card p-0 m-0 ">
                <div class="header px-2">Hello</div>
                <div class="body"><img src="/images/backgound-forum.jpeg"></div>
                <div class="commentary px-2">Goodbye</div>
            </div>
        </div>
    </div>


    <div class="gallery-panel bg-light">
        <p>ddaddadaadadaddasdas</p>
    </div>


</main>


<?php include_once "includes/footer.php" ?>