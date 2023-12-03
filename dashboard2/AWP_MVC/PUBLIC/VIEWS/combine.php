<?php
include('../../CONFIG/DB_Configuration.php');
session_start();

// Initialize $personID variable
$personID = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];

    // Validate barcode data
    if (empty($barcode)) {
        echo "Barcode is empty";
        exit;
    }

    // Fetch student information from the database
    $studentQuery = "SELECT person_ID FROM student WHERE student_ID = ?";
    $studentStmt = mysqli_prepare($conn, $studentQuery);
    mysqli_stmt_bind_param($studentStmt, "s", $barcode);
    mysqli_stmt_execute($studentStmt);
    $studentResult = mysqli_stmt_get_result($studentStmt);

    // Fetch employee information from the database
    $employeeQuery = "SELECT person_ID FROM employee WHERE employee_ID = ?";
    $employeeStmt = mysqli_prepare($conn, $employeeQuery);
    mysqli_stmt_bind_param($employeeStmt, "s", $barcode);
    mysqli_stmt_execute($employeeStmt);
    $employeeResult = mysqli_stmt_get_result($employeeStmt);

    if ($studentRow = mysqli_fetch_assoc($studentResult)) {
        $personID = $studentRow['person_ID'];
    } elseif ($employeeRow = mysqli_fetch_assoc($employeeResult)) {
        $personID = $employeeRow['person_ID'];
    } else {
        // If no matching record is found
        echo "No record found for barcode: $barcode";
        exit;
    }

    // Check for open visit
    $openVisitQuery = "SELECT * FROM visitor_log WHERE person_ID = ? AND time_Out IS NULL";
    $openVisitStmt = mysqli_prepare($conn, $openVisitQuery);
    mysqli_stmt_bind_param($openVisitStmt, "i", $personID);
    mysqli_stmt_execute($openVisitStmt);
    $openVisitResult = mysqli_stmt_get_result($openVisitStmt);

    if ($openVisitRow = mysqli_fetch_assoc($openVisitResult)) {
        // Check the time interval since the last entry for this visitor
        $lastEntryTime = getLastEntryTime($personID, $conn);
        $timeInterval = 60; // 1 minute interval
        $currentTime = time();

        if ($lastEntryTime === null || ($currentTime - strtotime($lastEntryTime)) > $timeInterval) {
            // Update the existing visit with the current time as time_Out
            $updateQuery = "UPDATE visitor_log SET time_Out = NOW() WHERE person_ID = ? AND time_Out IS NULL";

            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "i", $personID);
            $updateResult = mysqli_stmt_execute($updateStmt);

            if ($updateResult) {
                echo "Updated time_Out for existing visit: Person ID $personID, Time Out: " . date('Y-m-d H:i:s');
            
                // Update the existing visitor entry in the $_SESSION['visitors'] array
                $visitorUpdated = false;
                foreach ($_SESSION['visitors'] as &$visitor) {
                    if ($visitor['person_ID'] === $personID) {
                        $visitor['time_Out'] = date('Y-m-d H:i:s');
                        $visitorUpdated = true;
                        break; // Stop the loop once the visitor is found and updated
                    }
                }
            
                // If the visitor is not found in the session, add a new entry
                if (!$visitorUpdated) {
                    $newVisitor = array(
                        'person_ID' => $personID,
                        'time_In' => $openVisitRow['time_In'],
                        'time_Out' => date('Y-m-d H:i:s'),
                    );
                    $_SESSION['visitors'][] = $newVisitor;
                }
            
                // Redirect to today.php
                header("Location: today.php");
                exit();
            } else {
                echo "Error updating time_Out: " . mysqli_error($conn);
            }
        
        } else {
            // Time interval not met since the last entry for this visitor
            echo "Time interval not met since the last entry for person_ID: $personID";
        }
    } else {
        // No open visit found, insert a new record
        $insertQuery = "INSERT INTO visitor_log (person_ID, date_visited, time_In, time_Out) VALUES (?, NOW(), NOW(), NULL)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "i", $personID);
        $insertResult = mysqli_stmt_execute($insertStmt);

        if ($insertResult) {
            // Initialize $visitor array
            $visitor = array(
                'person_ID' => $personID,
            );

            $_SESSION['visitors'][] = $visitor;

            // Redirect to today.php
            header("Location:today.php");
            exit();
        } else {
            echo "<script>
                document.getElementById('messageModalBody').innerHTML = 'Error inserting new record: " . mysqli_error($conn) . "';
                $('#messageModal').modal('show');
            </script>";
        }

        mysqli_stmt_close($insertStmt);
    }
} //else {
   // echo '<h1>Scanning is not allowed at the current time.</h1>';
//}

function getLastEntryTime($personID, $conn)
{
    $query = "SELECT MAX(time_In) AS lastEntryTime FROM visitor_log WHERE person_ID = ? AND time_Out IS NULL";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $personID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['lastEntryTime'];
    }

    return null;
}

?>
