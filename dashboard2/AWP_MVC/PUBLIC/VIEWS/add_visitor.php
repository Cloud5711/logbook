<?php
include('../../CONFIG/DB_Configuration.php');

// Initialize variables to store user input
$firstName = $middleName = $lastName = $personType = $studentLevel = $course = $department = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $firstName = $_POST['first_Name'];
    $middleName = $_POST['middle_Name'];
    $lastName = $_POST['last_Name'];
    $personType = $_POST['Person_Type'];
    $studentLevel = $_POST['student_Level'];
    $course = $_POST['Course'];
    $department = $_POST['Department'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert data into the person table
        $insertPersonQuery = "INSERT INTO person (first_Name, middle_Name, last_Name, Person_Type) 
        VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insertPersonQuery);
        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $middleName, $lastName, $personType);
        $successPersonInsert = mysqli_stmt_execute($stmt);

        if (!$successPersonInsert) {
            throw new Exception("Error inserting into person table: " . mysqli_stmt_error($stmt));
        }

        // Get the last inserted ID
        $person_ID = mysqli_insert_id($conn);

        // Insert data into the student table
        $insertStudentQuery = "INSERT INTO student (person_ID, student_Level, Course, Department) 
        VALUES (?, ?, ?, ?)";

        $stmtStudent = mysqli_prepare($conn, $insertStudentQuery);
        mysqli_stmt_bind_param($stmtStudent, "isss", $person_ID, $studentLevel, $course, $department);
        $successStudentInsert = mysqli_stmt_execute($stmtStudent);

        if (!$successStudentInsert) {
            throw new Exception("Error inserting into student table: " . mysqli_stmt_error($stmtStudent));
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Redirect or display a success message as needed
        header('Location: success.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        mysqli_rollback($conn);

        // Print the error message
        echo $e->getMessage();
    } finally {
        // Close the statements
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmtStudent);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<!-- ... (your HTML remains unchanged) ... -->
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RESOURCES/CSS/add_visitor.css">
    <title>User Registration</title>
</head>
<body>
    <h2>Student Registration</h2>
    <form method="post" action="">
        <!-- Personal Information -->
        <label for="first_Name">First Name:</label>
        <input type="text" name="first_Name" required><br><br>

        <label for="middle_Name">Middle Name:</label>
        <input type="text" name="middle_Name"><br><br>

        <label for="last_Name">Last Name:</label>
        <input type="text" name="last_Name" required><br><br>

        <label for="Person_Type">Person Type:</label>
        <input type="text" name="Person_Type" required><br><br>

        <!-- Student Information -->
        <label for="student_level">Student Level:</label>
        <input type="text" name="student_Level"><br><br>

        <label for="Course">Course:</label>
        <input type="text" name="Course"><br><br>

        <label for="Department">Department:</label>
        <input type="text" name="Department"><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
