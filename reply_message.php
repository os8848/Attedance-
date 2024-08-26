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

// Fetch message details
$message_query = "SELECT * FROM messages WHERE id = '$id'";
$message_result = $conn->query($message_query);
$message = $message_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="reply-message-section">
        <h2>Reply to Message</h2>
        <form action="php/reply_message_action.php?id=<?php echo $id; ?>" method="POST">
            <label for="reply">Reply:</label>
            <textarea id="reply" name="reply" rows="5" required></textarea>

            <button type="submit" class="btn">Send Reply</button>
        </form>

        <h3>Original Message</h3>
        <p><strong>From:</strong> <?php echo $message['employee_name']; ?></p>
        <p><strong>Message:</strong> <?php echo $message['message']; ?></p>
        <p><strong>Date Sent:</strong> <?php echo $message['date_sent']; ?></p>
    </div>
</body>
</html>
