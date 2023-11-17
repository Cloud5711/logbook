<?php
include("../../CONFIG/connection.php");
include("header1.php");
include("sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RESOURCES/CSS/topuser.css">
    <link rel="stylesheet" href="path-to-bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<?php
$sql = "SELECT p.first_Name, p.middle_Name, p.last_Name, c.Taking, COUNT(v.person_ID) AS date_visited, p.profile
    FROM person p
    INNER JOIN student c ON p.person_ID = c.person_ID
    LEFT JOIN visitor_log v ON p.person_ID = v.person_ID
    GROUP BY p.person_ID
    ORDER BY date_visited DESC
    LIMIT 10";

$query_run = mysqli_query($conn, $sql);

if ($query_run) {
    $topUsers = [];
    while ($row = mysqli_fetch_assoc($query_run)) {
        $topUsers[] = [
            'first_Name' => $row['first_Name'],
            'middle_Name' => $row['middle_Name'],
            'last_Name' => $row['last_Name'],
            'Taking' => $row['Taking'],
            'date_visited' => $row['date_visited'],
            'profile' => $row['profile']
        ];
    }
} else {
    echo "Query execution failed: " . mysqli_error($conn);
}
?>
<br>
<h1>Top Library Users</h1>
<div class="center-table">
    <div class="table-container">
        <div class="table-wrapper">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
            <tr>
            <th>Profile</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Total Visits</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($topUsers as $user) {
            echo "<tr>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($user['profile']) . "' width='100' height='100'></td>";
            echo "<td>{$user['first_Name']}</td>";
            echo "<td>{$user['middle_Name']}</td>";
            echo "<td>{$user['last_Name']}</td>";
            echo "<td>{$user['Taking']}</td>";
            echo "<td>{$user['date_visited']}</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</div>
</div>
</div>
    </body>
    </head>
    </html>

