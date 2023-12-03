<?php
include('../../CONFIG/DB_Configuration.php');
session_start();


error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../RESOURCES/CSS/scan_barcode.css">
    
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<style>
body {
    background-image: linear-gradient(rgba(0, 178, 10, 0.2), white);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

#message {
    text-align: center;
    background-color: #4CAF50;
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-top: 20px;
    font-size: 24px;
    animation: fadeIn 0.8s ease-out forwards, fadeOut 0.3s ease-in 2s forwards;
}
</style>


</div>

</body>
</html>
<?php

// Set the time zone
date_default_timezone_set('Asia/Manila');

// Get the server's current time using DateTime class
$serverTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
$serverTimeStr = $serverTime->format('Y-m-d H:i:s');

// Display the server's current time
echo "Server Time: $serverTimeStr<br>";

// Get the current time using DateTime class
$currentTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
$currentTimeStr = $currentTime->format('H:i');

// Debugging output
echo "Current Time: $currentTimeStr<br>";

// Define the allowed scanning hours
$allowedMorningStart = new DateTime('07:00:00');
$allowedMorningEnd = new DateTime('12:00:00');
$allowedAfternoonStart = new DateTime('13:00:00');
$allowedAfternoonEnd = new DateTime('17:00:00');

// Check if the current time is within the allowed scanning hours
$allowedMorning = $currentTime >= $allowedMorningStart && $currentTime <= $allowedMorningEnd;
$allowedAfternoon = $currentTime >= $allowedAfternoonStart && $currentTime <= $allowedAfternoonEnd;

if (!$allowedMorning && !$allowedAfternoon) {
    echo '<div id="message" style="text-align: center; background-color: #ff0000; color: white; padding: 30px; border-radius: 10px; margin-top: 20px; font-size: 50px; opacity: 0; animation: fadeIn 0.3s ease-out forwards;">';
    echo "Scanning is only available between 7 am to 12 pm and 1 pm to 5 pm.";
    echo '</div>';
    exit(); // Exit the script
}

// Continue with the rest of your code
// ...





if (!isset($_SESSION['last_login_time'])) {
    $_SESSION['last_login_time'] = array();
    $_SESSION['last_person_ID'] = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barcode = $conn->real_escape_string($_POST['barcode']);

    $checkPerson = $conn->prepare("SELECT 
    student.person_ID AS student_person_ID,
    employee.person_ID AS employee_person_ID,
    person.last_Name,
    person.first_Name,
    person.middle_Name,
    student.student_ID,
    employee.employee_ID,
    visitor_log.time_In
FROM person
LEFT JOIN student ON student.person_ID = person.person_ID AND student.student_ID = ?
LEFT JOIN employee ON employee.person_ID = person.person_ID AND employee.employee_ID = ?
LEFT JOIN visitor_log ON visitor_log.person_ID = person.person_ID AND visitor_log.date_visited = CURDATE() AND visitor_log.time_Out IS NULL
WHERE student.student_ID IS NOT NULL OR employee.employee_ID IS NOT NULL");
$checkPerson->bind_param("ss", $barcode, $barcode);
$checkPerson->execute();
$personResult = $checkPerson->get_result();


    if ($personResult === false) {
        die("Error executing SELECT query for person: " . $conn->error);
    }
    

    if ($personResult->num_rows > 0) {
        $person = $personResult->fetch_assoc();
        
        $person_ID = $person['student_person_ID'] ?? $person['employee_person_ID'];
        
        $last_Name = $person['last_Name'];
        $first_Name = $person['first_Name'];
        $middle_Name = $person['middle_Name'];
        $student_ID = $person['student_ID'];
        $employee_ID = $person['employee_ID'];
        $time_In = $person['time_In'];

        // Update last scan time
        if (!isset($_SESSION['last_login_time']) || !is_array($_SESSION['last_login_time'])) {
            $_SESSION['last_login_time'] = array();
        }

        $lastScanTime = $_SESSION['last_login_time'][$person_ID];
        $currentTime = time();
        $timeDifference = $currentTime - $lastScanTime;

        if ($timeDifference >= 10 || ($_SESSION['last_person_ID'] !== $person_ID && $timeDifference >= 0)) {
            // Allow scan if 10 seconds have passed or different person ID scanned at the same time
            $_SESSION['last_login_time'][$person_ID] = $currentTime; // Update last scan time
            $_SESSION['last_person_ID'] = $person_ID;

            $checkExistingAttendance = $conn->prepare("SELECT * FROM visitor_log WHERE person_ID = ? AND date_visited = CURDATE() AND time_Out IS NULL");
            $checkExistingAttendance->bind_param("i", $person_ID);
            $checkExistingAttendance->execute();
            $existingAttendanceResult = $checkExistingAttendance->get_result();

            if ($existingAttendanceResult->num_rows > 0) {
                // Person has checked in, record time-out
                $updateAttendance = $conn->prepare("UPDATE visitor_log SET time_Out = CURTIME() WHERE person_ID = ? AND date_visited = CURDATE() AND time_Out IS NULL");
                $updateAttendance->bind_param("i", $person_ID);

                if ($updateAttendance->execute()) {
                    echo '<div id="message" style="text-align: center;">';
                    echo "Hi $last_Name, $middle_Name $first_Name, you've successfully timed out!";
                    echo '</div>';
                    echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "scan.php"; }, 2000);</script>';
                    exit();
                } else {
                    die("Error executing UPDATE query for attendance: " . $updateAttendance->error);
                }

                $updateAttendance->close();
            } else {
                // Different person ID scanned, insert a new record without considering the time interval
                $insertAttendance = $conn->prepare("INSERT INTO visitor_log (person_ID, date_visited, time_In, time_Out) VALUES (?, CURDATE(), CURTIME(), NULL)");
                $insertAttendance->bind_param("i", $person_ID);

                if ($insertAttendance->execute()) {
                    echo '<div id="message" style="text-align: center;">';
                    echo "Hi $last_Name, $middle_Name $first_Name, you've successfully timed in!";
                    echo '</div>';
                    echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "scan.php"; }, 2000);</script>';
                    exit();
                } else {
                    die("Error executing INSERT query for attendance: " . $insertAttendance->error);
                }

                $insertAttendance->close();
            }
        } else {
            $remainingTime = 10 - $timeDifference;
            echo '<div id="message" style="text-align: center;">';
            echo "Please wait at least $remainingTime seconds before scanning again.";
            echo '</div>';
            echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "scan.php"; }, 2000);</script>';
            echo '</script>';
        }
    } else {
        echo '<div style="text-align: center;">';
        echo "Person not found for barcode: $barcode";
        echo '</div>';
    }
}

$conn->close();
?>