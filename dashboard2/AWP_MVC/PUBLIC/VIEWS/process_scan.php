<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];

    // Validate barcode data
    if (empty($barcode)) {
        echo "Barcode is empty";
        exit;
    }

    // Check if the person is a student
    $studentQuery = "SELECT person_ID FROM student WHERE student_ID = ?";
    $studentStmt = mysqli_prepare($conn, $studentQuery);
    mysqli_stmt_bind_param($studentStmt, "s", $barcode);
    mysqli_stmt_execute($studentStmt);
    $studentResult = mysqli_stmt_get_result($studentStmt);

    // Check if the person is an employee
    $employeeQuery = "SELECT person_ID FROM employee WHERE employee_ID = ?";
    $employeeStmt = mysqli_prepare($conn, $employeeQuery);
    mysqli_stmt_bind_param($employeeStmt, "s", $barcode);
    mysqli_stmt_execute($employeeStmt);
    $employeeResult = mysqli_stmt_get_result($employeeStmt);

    // Initialize variable to store person_ID
    $personID = null;

    // If the person is a student, get person_ID and other details
    if ($studentRow = mysqli_fetch_assoc($studentResult)) {
        $personID = $studentRow['person_ID'];
        // Store student details in the $visitor array
        $visitor = $studentRow;
    }
    // If the person is an employee, get person_ID
    elseif ($employeeRow = mysqli_fetch_assoc($employeeResult)) {
        $personID = $employeeRow['person_ID'];
    } else {
        // If no matching record is found
        echo "No record found for barcode: $barcode";
        exit;
    }

    // Insert a new record into the visitor_log table
    $insertQuery = "INSERT INTO visitor_log (person_ID, date_visited, time_In, time_Out) VALUES (?, NOW(), NOW(), NULL)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertStmt, "s", $personID);
    $insertResult = mysqli_stmt_execute($insertStmt);

    if ($insertResult) {
        echo "Inserted new record for person_ID: $personID, Date Visited: " . date('Y-m-d') . ", Time In: " . date('H:i:s');
        // Store relevant data in sessions
      // When a new visitor is scanned
$visitor = array(
    'person_ID' => $personID,
    'last_Name' => $visitor['last_Name'],
    'first_Name' => $visitor['first_Name'],
    'middle_Name' => $visitor['middle_Name'],
    'Taking' => $visitor['Taking'],
    'student_Level' => $visitor['student_Level'],
    'time_In' => $visitor['time_In'],
    'time_Out' => $visitor['time_Out'],
);

// Initialize the visitors array in the session if it doesn't exist
if (!isset($_SESSION['visitors'])) {
    $_SESSION['visitors'] = array();
}

// Add the current visitor to the array
$_SESSION['visitors'][] = $visitor;

// Clear the session data for the current visitor
unset($_SESSION['person_ID']);
unset($_SESSION['last_Name']);
unset($_SESSION['first_Name']);
unset($_SESSION['middle_Name']);
unset($_SESSION['Taking']);
unset($_SESSION['student_level']);
unset($_SESSION['time_In']);
unset($_SESSION['time_Out']);

// Redirect to dashboard.php
header("Location: dashboard2.php");
exit();

    } else {
        // Log error details for debugging
        echo "Error inserting new record: " . mysqli_error($conn);
    }

    // Close prepared statements
    mysqli_stmt_close($studentStmt);
    mysqli_stmt_close($employeeStmt);
    mysqli_stmt_close($insertStmt);
    mysqli_close($conn);
}
?>
