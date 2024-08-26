<?php
// Fetch employee details based on ID
$id = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'attendance_db');
$employee_query = "SELECT * FROM employees WHERE id = '$id'";
$employee_result = $conn->query($employee_query);
$employee = $employee_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="edit-employee-section">
        <h2>Edit Employee</h2>
        <form action="php/edit_employee_action.php?id=<?php echo $employee['id']; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $employee['name']; ?>" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $employee['username']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">

            <button type="submit" class="btn">Update Employee</button>
        </form>
    </div>
</body>
</html>
