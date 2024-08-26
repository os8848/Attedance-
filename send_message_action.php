<?php
session_start();

// Check if employee is logged in
if (!isset($_SESSION['employee'])) {
    header("Location: ../employee_login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

$employee_id = $_SESSION['employee_id'];
$message = $_POST['message'];

// Insert message into the database
$insert_query = "INSERT INTO messages (employee_id, employee_name, message, date_sent) VALUES ('$employee_id', 'Employee Name', '$message', NOW())";
if ($conn->query($insert_query) === TRUE) {
    echo "<script>alert('Message sent successfully'); window.location.href = '../employee_messages.php';</script>";
} else {
    echo "<script>alert('Error sending message'); window.location.href = '../employee_messages.php';</script>";
}

$conn->close();
?>
