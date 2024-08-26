<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert employee into the database
    $insert_query = "INSERT INTO employees (name, username, password) VALUES ('$name', '$username', '$password')";
    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('Employee added successfully'); window.location.href = '../admin_dashboard.php?page=employee_info';</script>";
    } else {
        echo "<script>alert('Error adding employee'); window.location.href = '../add_employee.php';</script>";
    }
}

$conn->close();
?>
