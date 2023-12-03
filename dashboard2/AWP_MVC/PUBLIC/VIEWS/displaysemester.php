<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Your Web Page Title</title>
  <br><br>
<?php
include('../../CONFIG/DB_Configuration.php');

//echo "<a href='semester.php'><<</a>";//
$selectedSemester = isset($_GET['selectedSemester']) ? $_GET['selectedSemester'] : '';
$startMonth = isset($_GET['startMonth']) ? $_GET['startMonth'] : '';
$endMonth = isset($_GET['endMonth']) ? $_GET['endMonth'] : '';
$selectedYear = date('Y');



$query = "SELECT 
person.last_Name, person.first_Name, person.middle_Name, 
visitor_log.date_visited, visitor_log.time_In, visitor_log.time_Out, 
student.student_Level, student.Course
FROM visitor_log
JOIN person ON person.person_ID = visitor_log.person_ID
LEFT JOIN student ON person.person_ID = student.person_ID
WHERE (
        YEAR(visitor_log.date_visited) = ? AND MONTH(visitor_log.date_visited) BETWEEN ? AND ?
    )
ORDER BY visitor_log.date_visited DESC";

$stmt = mysqli_prepare($conn, $query);

// Bind the parameters
mysqli_stmt_bind_param($stmt, "sss", $selectedYear, $startMonth, $endMonth);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


if (!$result) {
    die('Error in main query: ' . mysqli_error($conn));
}


$queryTotalVisitors = "SELECT COUNT(DISTINCT person_ID) as total FROM visitor_log WHERE (
        YEAR(date_visited) = ? AND MONTH(date_visited) BETWEEN 8 AND 12
    )
    OR
    (
        YEAR(date_visited) = ? AND MONTH(date_visited) BETWEEN 1 AND 6
    )";

$stmtTotalVisitors = mysqli_prepare($conn, $queryTotalVisitors);

// Bind the parameters
mysqli_stmt_bind_param($stmtTotalVisitors, "ss", $selectedYear, $selectedYear);


mysqli_stmt_execute($stmtTotalVisitors);


$resultTotalVisitors = mysqli_stmt_get_result($stmtTotalVisitors);

// Check for SQL errors
if (!$resultTotalVisitors) {
    die('Error in total visitors query: ' . mysqli_error($conn));
}

// Fetch the total number of visitors using mysqli_fetch_assoc
$totalVisitorsRow = mysqli_fetch_assoc($resultTotalVisitors);

// Use isset to check if $totalVisitorsRow is not null and 'total' is set
$totalVisitors = (isset($totalVisitorsRow['total'])) ? $totalVisitorsRow['total'] : 0;

echo '<div class="container">';


echo '<table class="table table-bordered mt-3">';
echo '<thead class="thead-dark">';
echo '<tr>
<th>Last Name</th>
<th>Middle Name</th>
<th>First Name</th>
<th>Time In</th>
<th>Time Out</th>
<th>Course</th>
<th>Grade</th>
</tr>';
echo '</thead>';
echo '<tbody>';

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo '<tr>';
        echo '<td>' . $row['last_Name'] . '</td>';
        echo '<td>' . $row['middle_Name'] . '</td>';
        echo '<td>' . $row['first_Name'] . '</td>';
       
        echo '<td>' . $row['time_In'] . '</td>';
        echo '<td>' . $row['time_Out'] . '</td>';
        echo '<td>' . $row['Course'] . '</td>';
        echo '<td>' . $row['student_Level'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">Error fetching visitor information.</td></tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';

mysqli_close($conn);
?>

  </body>
</html>