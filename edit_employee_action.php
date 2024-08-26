<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Hash the new password
        $password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE employees SET name = '$name', username = '$username', password = '$password' WHERE id = '$id'";
    } else {
        // Update without changing the password
        $update_query = "UPDATE employees SET name = '$name', username = '$username' WHERE id = '$id'";
    }

    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Employee updated successfully'); window.location.href = '../admin_dashboard.php?page=employee_info';</script>";
    } else {
        echo "<script>alert('Error updating employee'); window.location.href = '../edit_employee.php?id=$id';</script>";
    }
}

$conn->close();
?>
