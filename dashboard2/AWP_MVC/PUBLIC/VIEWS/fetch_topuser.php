<?php
include('../../CONFIG/DB_Configuration.php');

if (isset($_POST["grade"])) {
    $grade = $_POST["grade"];

    $query = "SELECT
    DENSE_RANK() OVER (ORDER BY COUNT(visitor_log.person_ID) DESC) as ranking,
    person.last_Name,
    person.middle_Name,
    person.first_Name,
    student.student_Level,
    student.Department,
    visitor_log.date_visited,
    COUNT(visitor_log.person_ID) as date_visited
FROM
    person
JOIN
    student ON person.person_ID = student.person_ID
LEFT JOIN
    visitor_log ON student.person_ID = visitor_log.person_ID
WHERE
    student.student_Level = '$grade'
GROUP BY
    person.last_Name,
    person.middle_Name,
    person.first_Name,
    student.student_Level,
    student.Department
ORDER BY
    ranking
LIMIT 10";

    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
}
?>
<style>
    h2 {
        color: #5E7C2A;
        text-align: center;
    }

    .center-text {
        text-align: center;
    }

    .table th {
        text-align: center;
        color: #5E7C2A;
    }
</style>

<?php

if ($count > 0) {
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Department</th>
                    <th>Total Visit</th>
                </tr>
            </thead>
            <tbody>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>
                <td>' . $row['ranking'] . '</td>
                <td>' . $row['last_Name'] . '</td>
                <td>' . $row['first_Name'] . '</td>
                <td>' . $row['middle_Name'] . '</td>
                <td>' . $row['Department'] . '</td>
                <td>' . $row['date_visited'] . '</td>
              </tr>';
    }

    echo '</tbody></table>';
} else {
    echo "No data found.";
}
?>

