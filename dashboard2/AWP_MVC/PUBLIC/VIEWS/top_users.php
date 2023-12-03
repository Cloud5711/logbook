<?php
 include('../../CONFIG/DB_Configuration.php');
 include('index.php');

$queryAllDepartments = "SELECT
        DENSE_RANK() OVER (ORDER BY COUNT(visitor_log.person_ID) DESC) as ranking,
        person.last_Name,
        person.middle_Name,
        person.first_Name,
        student.student_Level,
        student.Department,  -- Include the department attribute from the student table
        visitor_log.date_visited,
        COUNT(visitor_log.person_ID) as date_visited
    FROM
        person
    JOIN
        student ON person.person_ID = student.person_ID
    LEFT JOIN
        visitor_log ON student.person_ID = visitor_log.person_ID
    GROUP BY
        person.last_Name,
        person.middle_Name,
        person.first_Name,
        student.student_Level,
        student.Department  -- Group by the department attribute as well
    ORDER BY
        ranking
    LIMIT 10";

$resultAllDepartments = mysqli_query($conn, $queryAllDepartments);
$countAllDepartments = mysqli_num_rows($resultAllDepartments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../RESOURCES/CSS/topuser.css">

    <style>
        body {
            background: rgb(237, 237, 237);
        }

        select {
            background: linear-gradient(145deg, #fff, #fff);
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            color: #000000;
        }

        label {
            background-color: rgb(237, 237, 237);
            background: linear-gradient(145deg, #fff, #fff);
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        h2 {
            color: #5E7C2A;
        }

        .center-text {
            text-align: center;
        }

        .table th {
            text-align: center;
            color: #5E7C2A;
        }
    </style>
    </head>

<body>    
    <br><br><br><br><br>
    <div class="container">
        <div id="filters">
            <div>
                <label for="categoryDropdown">Select Department:</label>
                <select id="categoryDropdown" onchange="showGrades()">
                    <option value="Department"disabled selected>Department</option>
                    <option value="Basic Education">Basic Education</option>
                    <option value="Junior HS">Junior HS</option>
                    <option value="Senior HS">Senior HS</option>
                    <option value="College">College</option>
                </select>
            </div>
                <div id="departmentDropdownForCollege" style="display: none;">
                <label for="departmentForCollege">College Department:</label>
                <select id="departmentForCollege" onchange="handleDepartmentSelection()">
                    <option value=""></option>
                </select>
                </div>
                <div id="programDropdownForCollege" style="display: none;">
                <label for="programForCollege">Select Program:</label>
                <select id="programForCollege" onchange="handleProgramSelection()">
                <option value=""></option>
              
                </select>
                </div>

               <div id="yearsDropdown" style="display: none;">
                    <label for="year">Select Year:</label>
                    <select id="year" onchange="showSections()">
                    <option value=""></option>
                    </select> 
                    </div>
    

               <div id="gradesDropdown" style="display: none;">
                <label for="grade">Select Grade:</label>
                <select id="grade" onchange="handleGradeSelection()">
                    <option value=""></option>
                </select>
            </div>
           </div>
          <br>
          <h2 class="center-text" id="top10Title">Top Library Users</h2>
          <?php
        if ($countAllDepartments > 0) {
            echo '<table class="table table-bordered" id="resultTable">
                    <thead>
                    <tbody>
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

            while ($row = mysqli_fetch_array($resultAllDepartments)) {
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

        <table class="table table-bordered" style="display: none;" id="gradeTable">
            <tbody>
                <!-- Table content will be inserted here dynamically -->
            </tbody>
        </table>
    </div>
    <script src="../RESOURCES/JS/top_user.js"></script>
    </body>
</html>