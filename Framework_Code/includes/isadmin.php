<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['email'])) {
    die("You are not logged in. Access denied.");
}
include 'database1.php';



$email = $_SESSION['email'];
$email = mysqli_real_escape_string($conn, $email);

$query = "SELECT * FROM IsAdmin WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("You do not have access to this page.");
}
$_SESSION["admin"] = "yes";
?>