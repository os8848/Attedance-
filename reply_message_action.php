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
$reply = $_POST['reply'];

// Insert the reply into the database
$reply_query = "INSERT INTO replies (message_id, reply, date_replied) VALUES ('$id', '$reply', NOW())";
if ($conn->query($reply_query) === TRUE) {
    echo "<script>alert('Reply sent successfully'); window.location.href = '../admin_dashboard.php?page=messages';</script>";
} else {
    echo "<script>alert('Error sending reply'); window.location.href = '../reply_message.php?id=$id';</script>";
}

$conn->close();
?>
