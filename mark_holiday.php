<?php
session_start();
if (date('N') == 6) { // 6 is Saturday in ISO-8601 format
    $insert_query = "INSERT INTO holidays (date) VALUES ('$date')";
    $conn->query($insert_query); // No need for error checking here, just mark it
}
// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.html");
    exit();
}

// Database connection (replace with your actual DB credentials)
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = date('Y-m-d');

    // Check if the date is already marked as a holiday
    $check_query = "SELECT * FROM holidays WHERE date = '$date'";
    $result = $conn->query($check_query);

    if ($result->num_rows == 0) {
        // Insert the current date as a holiday
        $insert_query = "INSERT INTO holidays (date) VALUES ('$date')";
        if ($conn->query($insert_query) === TRUE) {
            echo "<script>alert('Holiday marked successfully'); window.location.href = '../admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error marking holiday'); window.location.href = '../admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Today is already marked as a holiday'); window.location.href = '../admin_dashboard.php';</script>";
    }
}

$conn->close();
?>
