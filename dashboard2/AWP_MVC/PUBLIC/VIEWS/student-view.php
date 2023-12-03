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
    <title>Student View</title>
</head>
<body>
    <main>
        <section id="visitor-profile">
        <img src="data:image/jpeg;base64,<?= base64_encode($profile_image) ?>" alt="Visitor Profile">
        </section>
            <?php
            $visitor_name = "";
            if (isset($_GET['person_ID'])) {
                $person_id = $_GET['person_ID'];

                // Fetch daily visits
                $daily_sql = "SELECT * FROM visitor_log WHERE person_ID = ? AND date_visited = CURDATE()";
                $daily_stmt = mysqli_prepare($conn, $daily_sql);
                mysqli_stmt_bind_param($daily_stmt, "i", $person_id);
                mysqli_stmt_execute($daily_stmt);
                $daily_result = mysqli_stmt_get_result($daily_stmt);

                // Fetch monthly visits
                $monthly_sql = "SELECT * FROM visitor_log WHERE person_ID = ? AND MONTH(date_visited) = MONTH(CURDATE())";
                $monthly_stmt = mysqli_prepare($conn, $monthly_sql);
                mysqli_stmt_bind_param($monthly_stmt, "i", $person_id);
                mysqli_stmt_execute($monthly_stmt);
                $monthly_result = mysqli_stmt_get_result($monthly_stmt);

                // Fetch semester visits (assuming a semester lasts for 6 months)
                $semester_sql = "SELECT * FROM visitor_log WHERE person_ID = ? AND date_visited >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
                $semester_stmt = mysqli_prepare($conn, $semester_sql);
                mysqli_stmt_bind_param($semester_stmt, "i", $person_id);
                mysqli_stmt_execute($semester_stmt);
                $semester_result = mysqli_stmt_get_result($semester_stmt);

                $sql = "SELECT * FROM visitor_log WHERE person_ID = ?";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "i", $person_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Fetch the visitor's name
                    $name_sql = "SELECT first_Name, middle_Name, last_Name, profile FROM person WHERE person_ID = ?";
                    $name_stmt = mysqli_prepare($conn, $name_sql);
                    mysqli_stmt_bind_param($name_stmt, "i", $person_id);
                    mysqli_stmt_execute($name_stmt);
                    $name_result = mysqli_stmt_get_result($name_stmt);

                    if ($name_result && mysqli_num_rows($name_result) > 0) {
                        $name_row = mysqli_fetch_assoc($name_result);
                        $visitor_name = $name_row['first_Name'] . ' ' . $name_row['middle_Name'] . ' ' . $name_row['last_Name'];
                        $profile_image = $name_row['profile'];
                    }
                }
            }
            ?>
        </section>

        <aside id="student-profile">
            <h2>Student Profile</h2>
            <!-- Display student profile information here -->
            <?php
            // You can use $profile_image and other student profile information here
            ?>
        </aside>
    </main>

    <br><br>

    <?php

    if (isset($result) && mysqli_num_rows($result) > 0) {
        echo "<h1 style='text-align: center;'> $visitor_name</h1>";
        ?>
        <section>
            <h2>Daily Visits</h2>
            <table class="table table-bordered">
                <!-- Table header -->
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($daily_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['date_visited'] . "</td>";
                        echo "<td>" . $row['time_In'] . "</td>";
                        echo "<td>" . $row['time_Out'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Monthly Visits</h2>
            <table class="table table-bordered">
                <!-- Table header -->
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($monthly_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['date_visited'] . "</td>";
                        echo "<td>" . $row['time_In'] . "</td>";
                        echo "<td>" . $row['time_Out'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Semester Visits</h2>
            <table class="table table-bordered">
                <!-- Table header -->
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($semester_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['date_visited'] . "</td>";
                        echo "<td>" . $row['time_In'] . "</td>";
                        echo "<td>" . $row['time_Out'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

    <?php
    } else {
        echo "<h1>No attendance records found for $visitor_name</h1>";
    }
    ?>

</body>

</html>
