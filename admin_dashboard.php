<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin_login.html");
    exit();
}

// Database connection (replace with your actual DB credentials)
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

// Fetch total number of employees
$total_employees_query = "SELECT COUNT(*) as total FROM employees";
$total_employees_result = $conn->query($total_employees_query);
$total_employees = $total_employees_result->fetch_assoc()['total'];

// Fetch today's present employees
$today_absent_query = "SELECT * FROM attendance WHERE date = CURDATE() AND status = 'absent' AND CURDATE() NOT IN (SELECT date FROM holidays)";
$today_present_result = $conn->query($today_present_query);
$today_present = $today_present_result->num_rows;

// Fetch today's absent employees
$today_absent_query = "SELECT * FROM attendance WHERE date = CURDATE() AND status = 'absent'";
$today_absent_result = $conn->query($today_absent_query);
$today_absent = $today_absent_result->num_rows;

// Placeholder for other necessary queries

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-dashboard">
    <nav class="navbar">
    <ul>
        <li><a href="admin_dashboard.php">Home</a></li>
        <li><a href="admin_dashboard.php?page=employee_info">Employee Info</a></li>
        <li><a href="admin_dashboard.php?page=messages">Messages</a></li>
    </ul>
</nav>

<div class="content">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        include($page . ".php");
    } else {
        include("home.php"); // Default to Home section
    }
    ?>
</div>


        <div class="content">
            <h2>Welcome, Admin</h2>

            <div class="home-section">
                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="card">
                        <h3>Total Employees</h3>
                        <p id="total-employees"><?php echo $total_employees; ?></p>
                    </div>
                    <div class="card">
                        <h3>Today's Present</h3>
                        <p id="today-present"><?php echo $today_present; ?></p>
                    </div>
                    <div class="card">
                        <h3>Today's Absent</h3>
                        <p id="today-absent"><?php echo $today_absent; ?></p>
                    </div>
                </div>

                <!-- Mark as Holiday Button -->
                <div class="holiday-section">
    <form action="php/mark_holiday.php" method="POST">
        <button type="submit" id="mark-holiday">Mark as Holiday</button>
    </form>
</div>


                <!-- Today's Present Employees -->
                <div class="present-employee-list">
                    <h3>Today’s Present Employees</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name/Username</th>
                                <th>Arrival Time</th>
                                <th>Leave Time</th>
                            </tr>
                        </thead>
                        <tbody id="present-list">
                            <?php
                            $sn = 1;
                            while ($row = $today_present_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $sn++ . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['arrival_time'] . "</td>";
                                echo "<td>" . $row['leave_time'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Today's Absent Employees -->
                <div class="absent-employee-list">
                    <h3>Today’s Absent Employees</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name/Username</th>
                                <th>Absent Reason</th>
                            </tr>
                        </thead>
                        <tbody id="absent-list">
                            <?php
                            $sn = 1;
                            while ($row = $today_absent_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $sn++ . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['reason'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
