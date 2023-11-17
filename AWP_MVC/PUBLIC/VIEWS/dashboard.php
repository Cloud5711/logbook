<?php
include('../../CONFIG/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8 /">
<link rel="stylesheet" href="../RESOURCES/CSS/dashboard.css">

<title>Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


                    <body>
                   <div class="sidebar">
                   <div class="logo"></div>
                    <ul class="menu">
                    <li class="active">
                    <a href="#">
                    <i class="fas fa-tachometer-alt"></i>
                      <span>Dashboard</span>
                    </a>
                    </li>
                    <li>
                    <a href="admin_profile.php">
                    <i class="fas fa-user"></i>
                    <span>Admin</span>
                      
                    </a>
                    </li>
                    <li>
                    <a href="#">
                    <i class="fa-solid fa-barcode"></i>
                    <span>Scan Barcode</span>
                    </a>
                    </li>
                    <li class="logout">
                    <a href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    </a>
                    </li>
                    </ul>
                </div>
                <div class="main--content">
                <div class="header--wrapper">
                <div class="header--title">
                <img src="../../PUBLIC/RESOURCES/IMAGES/logo.png" alt="Avatar" class="avatar">
                <span>SAINT JOSEPH COLLEGE of BAGGAO</span>
                <h2>LIBRARY LOGBOOK SYSTEM</h2>
                </div>
                <div class="user--info">
                <div class="search--box">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Search" />
                </div>
                    
                </div>
                </div> 
                <div class="card--container">
                <h3 class="main--title">Statistical Report</h3>
                <div class="card--wrapper">
                <div class="visitor--card">
                <div class="card--header">
                <div class="number">
                <span class="title"><a href="jsfordaily.php" style="text-decoration: none; color: #000000;">Visitors Today:</a></span>
                                  
                                      
                                      
                <?php
                include('../../CONFIG/connection.php');

                $currentDate = date("Y-m-d"); // Get the current date in "YYYY-MM-DD" format
                $query= "SELECT person_ID FROM visitor_log WHERE date_visited='$currentDate'";
                $query_run=mysqli_query($conn,$query);

                $row = mysqli_num_rows($query_run);

               echo '<h1> '.$row.'</h1>';
               ?>
                                      
                                    
                                    
                                    
                </div>
                <class="fas fa-users icon "></>
                </div>
                </div>
                <div class="visitor--card light-blue">

                <div class="card--header">
                <div class="number">
                <span class="title"><a href="weekly.php" style="text-decoration: none; color: #000000;">Total Number of Visitors:</a></span>

                                        
                                        
                                        
                                        
                <?php
                include('../../CONFIG/connection.php');

                $query = "SELECT COUNT(*) AS weekly_visitors
                FROM visitor_log
                WHERE date_visited >= DATE_SUB(CURRENT_DATE, INTERVAL 1 WEEK)
                AND date_visited < CURRENT_DATE";  
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                $row = mysqli_fetch_assoc($query_run);
                $weeklyVisitorsCount = $row['weekly_visitors'];
                echo '<h1>' . $weeklyVisitorsCount . '</h1>';
                } else {
                echo "Query execution failed: " . mysqli_error($conn);
                }
                ?>                       

                </div>
                <i class="fa-solid fa-file-circle-check icon light-red"></i>
                </div>
                </div>
                <div class="visitor--card light-blue">
                <a href="index1.php" class="card-link">
                <div class="card--header">
                <div class="number">
                <span class="title">Top Users:</span>
                <?php
                $query = "SELECT p2.last_Name, COUNT(p1.person_ID) AS entry_count
                    FROM visitor_log p1
                    LEFT JOIN person p2 ON p1.person_ID = p2.person_ID
                    GROUP BY p2.person_ID
                    ORDER BY entry_count DESC
                    LIMIT 10";

            $query_run = mysqli_query($conn, $query);

            $row = mysqli_num_rows($query_run);


            if ($row > 0 && isset($_GET['top_users'])) {
            
                header("Location: index1.php");
                exit();
            }

            
            echo '<h1>' . $row . '</h1>';
            echo '</a>';

            ?>
            </div>
            <i class="fas fa-users icon light-green"></i>
            </div>
            </div>         
            </div>
            <div class= "scroll container">
            <div class="content-2">
                
        <div class="recent-visitors">
        <div class="title">
        <h2>Daily Visitors</h2>
        </div>
        <table>
        <table class="table table-bordered">

                    <table> 
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Course & Year</th>
                            <th> Date</th>
                            <th> Time In</th>
                            <th> Time Out</th>
                            <th> Profile</th> 
                    </thead>
                    <tbody>   
                    </div>
                    </body>

                <?php 
                $currentDate = date("Y-m-d");
                $sql = "SELECT visitor_log.date_visited, visitor_log.time_In, visitor_log.time_Out, person.person_ID, person.last_Name, person.first_Name, person.middle_Name, student.Taking, student.student_level
                        FROM visitor_log
                        INNER JOIN person ON visitor_log.person_ID = person.person_ID
                        INNER JOIN student ON visitor_log.person_ID = student.person_ID
                        WHERE visitor_log.date_visited = '$currentDate'";
                $query_run = mysqli_query($conn, $sql);


                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $visitor)
                    {
                        
                        ?>
                        <tr>
            
            <td><?= $visitor['last_Name'], ", ",$visitor['first_Name'], " ",$visitor['middle_Name'];  ?></td>
            <td><?= $visitor['Taking'], " /",$visitor['student_level']; ?></td>
            <td><?= $visitor['date_visited']; ?></td>
            <td><?= $visitor['time_In']; ?></td>
            <td><?= $visitor['time_Out']; ?></td>

             <style>
            table, tr, td{
            text-align: center;
        
           }
           </style>
            <td>
            <a href="student-view.php?person_ID=<?=$visitor['person_ID']; ?>" class="btn btn-info btn-sm">View</a>
                        <form action="code.php" method="GET" class="d-inline">
            </form>
            </td>
            </tr>
        
    
            <?php
                }
            } else {
                // Handle query execution error
                echo "" . mysqli_error($conn);
            }
            ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       </div>
       </div>
    
        </body>
       </head>
       </html>





 

