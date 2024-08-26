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

// Fetch employee details
$employee_query = "SELECT * FROM employees WHERE id = '$id'";
$employee_result = $conn->query($employee_query);
$employee = $employee_result->fetch_assoc();

// Fetch current month's attendance
$current_month = date('Y-m');
$attendance_query = "SELECT * FROM attendance WHERE employee_id = '$id' AND DATE_FORMAT(date, '%Y-%m') = '$current_month'";
$attendance_result = $conn->query($attendance_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="employee-details-section">
        <h2><?php echo $employee['name']; ?>'s Attendance Details</h2>
        
        <h3>Current Month Attendance (<?php echo date('F Y'); ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Arrival Time</th>
                    <th>Leave Time</th>
                    <th>Reason (if Absent)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $attendance_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . ucfirst($row['status']) . "</td>";
                    echo "<td>" . $row['arrival_time'] . "</td>";
                    echo "<td>" . $row['leave_time'] . "</td>";
                    echo "<td>" . $row['reason'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Dropdown to view past records -->
        <h3>View Past Attendance Records</h3>
        <form method="GET" action="employee_details.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="month">Select Month:</label>
            <select name="month" id="month">
                <?php
                // Generate dropdown options for the past 12 months
                for ($i = 0; $i < 12; $i++) {
                    $month = date('Y-m', strtotime("-$i month"));
                    echo "<option value='$month'>" . date('F Y', strtotime("-$i month")) . "</option>";
                }
                ?>
            </select>
            <button type="submit">View</button>
        </form>

        <?php
        if (isset($_GET['month'])) {
            $selected_month = $_GET['month'];

            // Fetch attendance for the selected month
            $selected_attendance_query = "SELECT * FROM attendance WHERE employee_id = '$id' AND DATE_FORMAT(date, '%Y-%m') = '$selected_month'";
            $selected_attendance_result = $conn->query($selected_attendance_query);

            echo "<h3>Attendance for " . date('F Y', strtotime($selected_month)) . "</h3>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Date</th>";
            echo "<th>Status</th>";
            echo "<th>Arrival Time</th>";
            echo "<th>Leave Time</th>";
            echo "<th>Reason (if Absent)</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $selected_attendance_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . ucfirst($row['status']) . "</td>";
                echo "<td>" . $row['arrival_time'] . "</td>";
                echo "<td>" . $row['leave_time'] . "</td>";
                echo "<td>" . $row['reason'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }
        ?>

        <!-- Pie Chart for Attendance Summary -->
        <h3>Attendance Summary</h3>
        <div id="attendance-pie-chart"></div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('attendance-pie-chart').getContext('2d');
            const attendanceChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Present', 'Absent'],
                    datasets: [{
                        label: 'Attendance Summary',
                        data: [
                            <?php
                            $present_count_query = "SELECT COUNT(*) as count FROM attendance WHERE employee_id = '$id' AND status = 'present' AND DATE_FORMAT(date, '%Y-%m') = '$current_month'";
                            $absent_count_query = "SELECT COUNT(*) as count FROM attendance WHERE employee_id = '$id' AND status = 'absent' AND DATE_FORMAT(date, '%Y-%m') = '$current_month'";

                            $present_count_result = $conn->query($present_count_query)->fetch_assoc();
                            $absent_count_result = $conn->query($absent_count_query)->fetch_assoc();

                            echo $present_count_result['count'] . ', ';
                            echo $absent_count_result['count'];
                            ?>
                        ],
                        backgroundColor: ['#4caf50', '#f44336'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                }
            });
        </script>
    </div>
</body>
</html>
