<?php
session_start();

// Dummy credentials for admin (you can later replace this with database checks)
$admin_username = "admin";
$admin_password = "admin123";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if admin credentials are correct
    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['admin'] = $username;
        header("Location: ../admin_dashboard.html");
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href = '../admin_login.html';</script>";
    }
}
?>
