<?php
 include('../../CONFIG/DB_Configuration.php');
// Output data for inspection

// Fetch monthly data for the entire year
$queryMonthly = "SELECT DATE_FORMAT(date_visited, '%Y-%m') as month, 
COUNT(date_visited) as count FROM visitor_log WHERE date_visited >= DATE_SUB(NOW(), 
INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(date_visited, '%Y-%m') ORDER BY date_visited ASC";


$resultMonthly = mysqli_query($conn, $queryMonthly);

$monthlyData = array();
while ($row = mysqli_fetch_assoc($resultMonthly)) {
    $monthlyData[$row['month']] = $row['count'];
}

$data = array(
    "Monthly" => $monthlyData
);

header('Content-Type: application/json');
echo json_encode($data);
?>
