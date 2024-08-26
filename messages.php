<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

// Fetch all messages
$messages_query = "SELECT * FROM messages ORDER BY date_sent DESC";
$messages_result = $conn->query($messages_query);

$conn->close();
?>

<div class="messages-section">
    <h2>Messages</h2>
    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Message</th>
                <th>Date Sent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = 1;
            while ($row = $messages_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $sn++ . "</td>";
                echo "<td>" . $row['employee_name'] . "</td>";
                echo "<td>" . $row['message'] . "</td>";
                echo "<td>" . $row['date_sent'] . "</td>";
                echo "<td>";
                echo "<a href='reply_message.php?id=" . $row['id'] . "'>Reply</a> | ";
                echo "<a href='delete_message.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
