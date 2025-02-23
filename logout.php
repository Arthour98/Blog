<?php require_once "database/config.php";
session_start();

if (isset($_SESSION["user_id"])) {
    session_destroy();
    header("location:login.php");
    exit;
} else {
    header("location:index.php");
    exit;
}
