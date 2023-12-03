<?php
include('../../CONFIG/DB_Configuration.php');

// Initialize variables to store user input
$firstName = $middleName = $lastName = $personType = $rank = $positionName = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize user input
    $firstName = mysqli_real_escape_string($conn, $_POST['first_Name']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middle_Name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_Name']);
    $personType = mysqli_real_escape_string($conn, $_POST['Person_Type']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $positionName = mysqli_real_escape_string($conn, $_POST['Position_Name']);

    // Insert data into the person table
    $insertPersonQuery = "INSERT INTO person (first_Name, middle_Name, last_Name, Person_Type) 
    VALUES (?, ?, ?, ?)";

    $stmtPerson = mysqli_prepare($conn, $insertPersonQuery);
    mysqli_stmt_bind_param($stmtPerson, "ssss", $firstName, $middleName, $lastName, $personType);
    $successPersonInsert = mysqli_stmt_execute($stmtPerson);

    // Insert data into the employee table
    $insertEmployeeQuery = "INSERT INTO employee (rank) 
    VALUES (?)";

    $stmtEmployee = mysqli_prepare($conn, $insertEmployeeQuery);
    mysqli_stmt_bind_param($stmtEmployee, "s", $rank);
    $successEmployeeInsert = mysqli_stmt_execute($stmtEmployee);

    // Get the last inserted employee ID
    $lastInsertedEmployeeID = mysqli_insert_id($conn);

    // Insert data into the position table
    $insertPositionQuery = "INSERT INTO position (position_Name) 
    VALUES (?)";

    $stmtPosition = mysqli_prepare($conn, $insertPositionQuery);
    mysqli_stmt_bind_param($stmtPosition, "s",  $positionName);
    $successPositionInsert = mysqli_stmt_execute($stmtPosition);

    if ($successPersonInsert && $successEmployeeInsert && $successPositionInsert) {
        // Provide feedback to the user
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_stmt_error($stmtPerson) . " - " . mysqli_stmt_error($stmtEmployee) . " - " . mysqli_stmt_error($stmtPosition);
    }

    // Close the statements
    mysqli_stmt_close($stmtPerson);
    mysqli_stmt_close($stmtEmployee);
    mysqli_stmt_close($stmtPosition);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RESOURCES/CSS/add_visitor.css">
    <title>Employee Registration</title>
</head>
<body>
    <h2>Employee Registration</h2>
    <form method="post" action="">
        <!-- Personal Information -->
        <label for="first_Name">First Name</label>
        <input type="text" name="first_Name" required><br><br>

        <label for="middle_Name">Middle Name</label>
        <input type="text" name="middle_Name"><br><br>

        <label for="last_Name">Last Name</label>
        <input type="text" name="last_Name" required><br><br>

        <label for="Person_Type">Person Type</label>
        <input type="text" name="Person_Type" required><br><br>

        <label for="rank">Rank</label>
        <input type="text" name="rank" required><br><br>

        <label for="position_Name">Position Name</label>
        <input type="text" name="Position_Name" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
