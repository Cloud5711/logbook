<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        h2 {
            text-align: center;
        }
        table {
            justify-content: center;
            width: 50%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 3px solid #ccc;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
    </style>
      <br><br>  <br>
    <title>All Visitors</title>
</head>

<body>
    <main>
        <section>
            <h2>All Visitors</h2>
            <?php
            // Fetch all visitors with their names, student level, and course
            $all_visitors_sql = "SELECT v.*, 
                                        CONCAT(p.first_Name, ' ', p.middle_Name, ' ', p.last_Name) AS full_Name,
                                        s.student_Level, s.Course
                                 FROM visitor_log v 
                                 JOIN person p ON v.person_ID = p.person_ID
                                 LEFT JOIN student s ON p.person_ID = s.person_ID";
            $all_visitors_result = mysqli_query($conn, $all_visitors_sql);

            if ($all_visitors_result) {
                if (mysqli_num_rows($all_visitors_result) > 0) {
                    ?>
                    <table class="table table-bordered">
                        <!-- Table header -->
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Student Level</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($all_visitors_result)) {
                                echo "<tr>";
                                echo "<td>" . $row['full_Name'] . "</td>";
                                echo "<td>" . $row['student_Level'] . "</td>";
                                echo "<td>" . $row['Course'] . "</td>";
                                echo "<td>" . $row['date_visited'] . "</td>";
                                echo "<td>" . $row['time_In'] . "</td>";
                                echo "<td>" . $row['time_Out'] . "</td>";
                                // Add more cells for additional columns
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "<p>No visitors found in the database.</p>";
                }
            } else {
                die("Error: " . mysqli_error($conn));
            }
            ?>
        </section>
    </main>
</body>

</html>
