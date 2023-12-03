<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');

// Link to go back to dashboard for a new search
//echo "<a href='dashboard.php'><<</a>";//
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_button'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $search_query = "SELECT person.person_ID, person.last_Name, person.first_Name, person.middle_Name, person.Person_Type, student.Course, student.student_Level, visitor_log.date_visited,
        visitor_log.time_In, visitor_log.time_Out 
        FROM person
        JOIN student ON person.person_ID = student.person_ID
        LEFT JOIN visitor_log ON person.person_ID = visitor_log.person_ID
        WHERE person.first_Name LIKE ? OR
            person.middle_Name LIKE ? OR
            person.last_Name LIKE ? OR
            person.Person_Type LIKE ? OR
            visitor_log.date_visited LIKE ? OR
            visitor_log.time_In LIKE ? OR
            visitor_log.time_Out LIKE ? OR
            student.Course LIKE ? OR
            student.student_Level LIKE ?";

    $stmt = mysqli_prepare($conn, $search_query);

    
    mysqli_stmt_bind_param($stmt, "sssssssss", $search, $search, $search, $search, $search, $search, $search, $search, $search);

    mysqli_stmt_execute($stmt);
    $search_result = mysqli_stmt_get_result($stmt);

    if (!$search_result) {
        die("Query failed: " . mysqli_error($conn));
    }

    
    $searchResultsData = [];
    while ($row = mysqli_fetch_assoc($search_result)) {
        $searchResultsData[] = $row;
    }


    // Display the search results
    echo "<table class='table table-center' style='padding-left: 20%; margin: 1.5%;'>";
    echo "<tr><br><br><br>
            <th>Grade</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Person Type</th>
            <th>Course</th>
           
          </tr>";

    foreach ($searchResultsData as $row) {
        echo "<tr>";
        echo "<td>" . $row['student_Level'] . "</td>";
        echo "<td>" . $row['first_Name'] . "</td>";
        echo "<td>" . $row['middle_Name'] . "</td>";
        echo "<td>" . $row['last_Name'] . "</td>";
        echo "<td>" . $row['Person_Type'] . "</td>";
        echo "<td>" . $row['Course'] . "</td>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    mysqli_stmt_close($stmt);
}

?>