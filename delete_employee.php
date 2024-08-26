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

// Delete employee from the database
$delete_query = "DELETE FROM employees WHERE id = '$id'";
if ($conn->query($delete_query) === TRUE) {
    echo "<script>alert('Employee deleted successfully'); window.location.href = '../admin_dashboard.php?page=employee_info';</script>";
} else {
    echo "<script>alert('Error deleting employee'); window.location.href = '../admin_dashboard.php?page=employee_info';</script>";
}

$conn->close();
?>
