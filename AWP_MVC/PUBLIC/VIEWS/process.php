<?php
include("database/connection.php");
// Assuming you have a database set up

// Get data from the form
$person_id = $_POST['person_ID'];
$date_visited = $_POST['date_visited'];
$time_in = $_POST['time_In'];
$time_out = $_POST['time_Out'];

// Insert attendance data into the database
$sql = "INSERT INTO visitor_log (person_ID, date_visited, time_In, time_Out) VALUES ($person_id, '$date_visited', '$time_in', '$time_out')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance recorded successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "SELECT * FROM visitor_log";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>person_ID</th>
        <th>date_visited</th>
        <th>time In</th>
        <th>time Out</th>
    </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['person_ID'] . "</td>";
        echo "<td>" . $row['date_visited'] . "</td>";
        echo "<td>" . $row['time_In'] . "</td>";
        echo "<td>" . $row['time_Out'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No attendance records found";
}


$conn->close();


// Retrieve attendance records from the database


?>
