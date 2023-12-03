<?php
// Your database connection code here
include('../../CONFIG/DB_Configuration.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];

    // Check if the person is a student
    $studentQuery = "SELECT person_ID FROM student WHERE student_ID = '$barcode'";
    $studentResult = mysqli_query($conn, $studentQuery);

    // Check if the person is an employee
    $employeeQuery = "SELECT person_ID FROM employee WHERE employee_ID = '$barcode'";
    $employeeResult = mysqli_query($conn, $employeeQuery);

    // Initialize variable to store person_ID
    $personID = null;

    // Initialize an array to store visitor data
    $visitor = array();

    // If the person is a student, get person_ID and other details
    if ($studentRow = mysqli_fetch_assoc($studentResult)) {
        $personID = $studentRow['person_ID'];
        $visitor = $studentRow; // Store student details in the $visitor array
    }
    // If the person is an employee, get person_ID
    elseif ($employeeRow = mysqli_fetch_assoc($employeeResult)) {
        $personID = $employeeRow['person_ID'];
    } else {
        // If no matching record is found
        echo "No record found for barcode: $barcode";
        exit;
    }

    // Check if there is an open visit for the person
    $openVisitQuery = "SELECT * FROM visitor_log WHERE person_ID = '$personID' AND time_Out IS NULL";
    $openVisitResult = mysqli_query($conn, $openVisitQuery);

    if ($openVisitRow = mysqli_fetch_assoc($openVisitResult)) {
        // Update the existing visit with the current time as time_Out
        $updateQuery = "UPDATE visitor_log SET time_Out = NOW() WHERE person_ID = '$personID' AND time_Out IS NULL";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo "Updated time_Out for existing visit: Visit ID $visitID, Time Out: " . date('Y-m-d H:i:s');
            // Store relevant data in sessions
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
            echo "Error updating time_Out: " . mysqli_error($conn);
        }
    } else {
        echo "No open visit found for person_ID: $personID";
    }
}
?>
