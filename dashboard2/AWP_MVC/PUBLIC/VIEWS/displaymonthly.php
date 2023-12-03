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
 
//echo "<a href='monthly.php'><<</a>";//
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : '';
$query = "SELECT 
person.last_Name, person.first_Name, person.middle_Name, 
visitor_log.date_visited, visitor_log.time_In, visitor_log.time_Out, 
student.student_Level, student.Course
FROM visitor_log
JOIN person ON person.person_ID = visitor_log.person_ID
LEFT JOIN student ON person.person_ID = student.person_ID
WHERE DATE_FORMAT(visitor_log.date_visited, '%Y-%m') = '$selectedMonth'
ORDER BY visitor_log.date_visited DESC";

$result = mysqli_query($conn, $query);

// Fetch the total number of visitors for the selected month
$queryTotalVisitors = "SELECT COUNT(DISTINCT person_ID) as total FROM visitor_log WHERE DATE_FORMAT(date_visited, '%Y-%m') = '$selectedMonth'";
$resultTotalVisitors = mysqli_query($conn, $queryTotalVisitors);
$totalVisitors = ($resultTotalVisitors) ? mysqli_fetch_assoc($resultTotalVisitors)['total'] : 0;
echo '<div class="container">';
echo '<table class="table table-bordered mx-auto mt-5">';
echo '<thead class="thead-dark">';
echo '<tr>
<th>Last Name</th>
<th>Middle Name</th>
<th>First Name</th>
<th>Date Visited</th>
<th>Time In</th>
<th>Time Out</th> 
<th>Course</th>
<th>Grade</th>
</tr>';
echo '</thead>';
echo '<tbody>';

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Display visitor information in a table row for each fetched row
        echo '<tr>';
        echo '<td>' . $row['last_Name'] . '</td>';
        echo '<td>' . $row['middle_Name'] . '</td>';
        echo '<td>' . $row['first_Name'] . '</td>';
        echo '<td>' . $row['date_visited'] . '</td>';
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