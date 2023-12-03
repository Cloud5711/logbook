<?php 
include('../../CONFIG/DB_Configuration.php');

 $today = '2023-08-21'; // Set the starting date (Monday)
 $endDate = '2023-08-26'; // Set the ending date (Saturday)
 
 // Calculate the end date (Saturday) of the current week
 $startDate = date('Y-m-d', strtotime($today . ' -' . (date('N', strtotime($today)) - 1) . ' days'));
 
 $query = "SELECT 
     DAYNAME(date_visited) AS day, 
     COUNT(*) AS visitors_count
 FROM visitor_log
 WHERE DATE(date_visited) BETWEEN '$startDate' AND '$endDate'
 AND DAYOFWEEK(date_visited) <> 1  -- Exclude Sundays (Day 1)
 GROUP BY day";
 
 $result = $conn->query($query);
 
 $data = array(
     'Monday' => 0,
     'Tuesday' => 0,
     'Wednesday' => 0,
     'Thursday' => 0,
     'Friday' => 0,
     'Saturday' => 0
 );
 
 while ($row = $result->fetch_assoc()) {
     $day = $row['day'];
     $count = $row['visitors_count'];
     $data[$day] = $count;
 }
 
 $conn->close();
 
 echo json_encode($data);
 ?>