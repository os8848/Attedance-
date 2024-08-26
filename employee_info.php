<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

// Fetch all employees
$employees_query = "SELECT * FROM employees";
$employees_result = $conn->query($employees_query);

$conn->close();
?>

<div class="employee-info-section">
    <h2>Employee Information</h2>

    <!-- Add Employee Button -->
    <div class="add-employee">
        <a href="add_employee.php" class="btn">Add New Employee</a>
    </div>

    <!-- Employee List -->
    <div class="employee-list">
        <h3>Employee List</h3>
        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = 1;
                while ($row = $employees_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $sn++ . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_employee.php?id=" . $row['id'] . "'>Edit</a> | ";
                    echo "<a href='delete_employee.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
