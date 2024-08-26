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

// Delete message from the database
$delete_query = "DELETE FROM messages WHERE id = '$id'";
if ($conn->query($delete_query) === TRUE) {
    echo "<script>alert('Message deleted successfully'); window.location.href = '../admin_dashboard.php?page=messages';</script>";
} else {
    echo "<script>alert('Error deleting message'); window.location.href = '../admin_dashboard.php?page=messages';</script>";
}

$conn->close();
?>
