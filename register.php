<?php require_once "database/config.php";
require_once "classes/user.php";

use classes\user\User;

session_start();
$db = new Database();
$conn = $db->connect();

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $users = new User($conn);
    $register = $users->register($name, $password, $email);

    if ($register) {
        header("location:login.php");
        $_SESSION["successMessage"] = "Account Created Successfully";
        exit;
    } else {
        header("location:register.php");
        $_SESSION["errorMessage"] = "There Was a Error";
        exit;
    }
}





?>
<?php include_once "includes/header.php" ?>
<?php if (!empty($_SESSION["errorMessage"])): ?>
    <div class="container w-25% mt-3">
        <div class="alert alert-danger alert-dismissible fade show " role="alert">
            <p class="text-center"><?php echo $_SESSION["errorMessage"]; ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    </div>
    <?php unset($_SESSION['errorMessage']); ?>
<?php endif; ?>

<div class="container border border-3 border-dark rounded-4 mt-4 py-3 shadow-lg">
    <form action="/register.php" class="d-flex flex-column align-items-center" method="POST">
        <h2 class="text-center font-weight-bold">Register</h2>
        <div class="my-3  w-50">
            <label for="username" class="form-check-label">Username:</label>
            <input type="text" class="form-control" name="username" id="username">
        </div>
        <div class=" my-3 w-50">
            <label for="password" class="form-check-label">Password:</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="my-3 w-50">
            <label for="email" class="form-check-label">Email:</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="my-3 w-50">
            <input type="submit" class="btn btn-primary mt-2" value="Register" name="register">
            <a class="link-light ms-3" href="login.php">Already Registered?</a>
        </div>
    </form>
</div>





<?php include_once "includes/footer.php" ?>