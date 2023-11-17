<?php
include ('../../CONFIG/connection.php');
include("../VIEWS/header.php");
?>
<!doctype html>
<html lang="en">
 
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../RESOURCES/CSS/view.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student View</title>

    <head>


   

<body>
<div class="title2"></div>
</head>
<body>

   

    <main>
        <section id="attendance-table">
        </head>
<body>


        </section>

        <aside id="student-profile">
        
        </aside>
    </main>


  
</head>

<body>
   
    <?php
     $visitor_name="";
    
    if (isset($_GET['person_ID'])) {
        $person_id = $_GET['person_ID'];
       
        $sql = "SELECT * FROM visitor_log WHERE person_ID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $person_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Fetch the visitor's name
            $name_sql = "SELECT first_Name, last_Name, middle_Name, profile FROM person WHERE person_ID = ?";
            $name_stmt = mysqli_prepare($conn, $name_sql);
            mysqli_stmt_bind_param($name_stmt, "i", $person_id);
            mysqli_stmt_execute($name_stmt);
            $name_result = mysqli_stmt_get_result($name_stmt);
            $visitor_name = "";
            $profile_image = null;

            if ($name_result && mysqli_num_rows($name_result) > 0) {
                $name_row = mysqli_fetch_assoc($name_result);
                $visitor_name = $name_row['first_Name'] . ' ' . $name_row['last_Name'] . ' ' . $name_row['middle_Name'];
                $profile_image = $name_row['profile']; 
            }
        }
    }
    ?>

<?php
    if (isset($result) && mysqli_num_rows($result) > 0) {
        echo "<h1> $visitor_name</h1>";
        ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                </tr>
            </thead>
            <tbody id="attendance-table-container"> 
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['date_visited'] . "</td>";
                    echo "<td>" . $row['time_In'] . "</td>";
                    echo "<td>" . $row['time_Out'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h1>No attendance records found for $visitor_name</h1>";
    }
    ?>

    <div id="visitor-profile">
        <img src="data:image/jpeg;base64,<?= base64_encode($profile_image) ?>" alt="Visitor Profile">
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>