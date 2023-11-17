<?php
include("../../CONFIG/connection.php");
include("sidebar&navbar.php");

// Get the selected day and visitors count from the URL parameters
$selectedDay = isset($_GET['selectedDay']) ? $_GET['selectedDay'] : '';
$visitorsCount = isset($_GET['visitorsCount']) ? $_GET['visitorsCount'] : '';

// Validate the input to prevent SQL injection (use prepared statements)
$selectedDay = mysqli_real_escape_string($conn, $selectedDay);
$visitorsCount = intval($visitorsCount); // Convert to integer

// Use prepared statements to prevent SQL injection
$query = $conn->prepare("SELECT 
    person.last_Name, person.first_Name, person.middle_Name, 
    visitor_log.date_visited, visitor_log.time_In, visitor_log.time_Out, 
    student.student_Level, student.Taking
    FROM visitor_log
    JOIN person ON person.person_ID = visitor_log.person_ID
    LEFT JOIN student ON person.person_ID = student.person_ID
    WHERE DAYNAME(visitor_log.date_visited) = ?
    LIMIT ?");
$query->bind_param("si", $selectedDay, $visitorsCount);
$query->execute();

$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Data for <?php echo htmlspecialchars($selectedDay); ?></title>
    <style>
       
        h1 {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1>Visitor Data for <?php echo htmlspecialchars($selectedDay); ?></h1><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Student Level</th>
                    <th>Taking</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['last_Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['middle_Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time_In']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time_Out']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['student_Level']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Taking']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
