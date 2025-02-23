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

    $users = new User($conn);
    $login = $users->login($name, $password);
    $user = $users->fetchUser($name);

    if ($login === true) {
        header("location:index.php");
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["successMessage"] = "Login Successfull";
        exit;
    } else {
        header("location:login.php");
        $_SESSION["errorMessage"] = "Your Details Doesnt Match";
        exit;
    }
}


?>

<?php include_once "includes/header.php" ?>

<?php if (!empty($_SESSION["successMessage"])): ?>
    <div class="container w-25% mt-3">
        <div class="alert alert-success alert-dismissible fade show " role="alert">
            <p class="text-center"><?php echo $_SESSION["successMessage"]; ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    </div>
    <?php unset($_SESSION['successMessage']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION["errorMessage"])) : ?>
    <div class="container w-25% mt-3">
        <div class="alert alert-danger alert-dismissible fade show " role="alert">
            <p class="text-center"><?php echo $_SESSION["errorMessage"]; ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    </div>
    <?php unset($_SESSION['errorMessage']); ?>

<?php endif; ?>
<div class="container border border-3 border-dark rounded-4 mt-4 py-3 shadow-lg">
    <form action="login.php" class="d-flex flex-column align-items-center"
        method="POST">
        <h2 class="text-center font-weight-bold">Login</h2>
        <div class="my-3  w-50">
            <label class="form-check-label">Username:</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="my-3  w-50">
            <label class="form-check-label">Password:</label>
            <input type="password" class="form-control" name=" password">
        </div>
        <div class="my-3 w-50">
            <input type="submit" class="btn btn-primary mt-2" value="Login">
            <a class="link-light ms-3" href="register.php">Not Registered Yet?</a>
        </div>
    </form>
</div>





<?php include_once "includes/footer.php" ?>