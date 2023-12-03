<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
        $currentDate = date("Y-m-d");
        echo $currentDate;
        ?>
                <span><i  ></i></span> <br><br>   <br><br>
               <p style="font-weight: bold; font-size: 25px; text-align: center;">Daily Visitors</p>
              </div>
              <div class="card-body">
                <div class="table-responsive" style="padding-left: 14%; margin-bottom: 15%;">
                <style>
            /* Apply custom styles for table padding */
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 0; /* Remove default margin to reduce space */
            }

            th, td {
                padding: 100%; /* Adjust the padding as needed */
            }
        </style>
                  <table id="example" class="table" style="width: 70%">

                    <table class="table table-bordered">
                    <thead>
                      <tr>
                            <th> Name</th>
                            <th> Course & Year</th>
                            <th> Date</th>
                            <th> Time In</th>
                            <th> Time Out</th>
                           
                        <?php 
                        $currentDate = date("2023-m-d");
                        $sql = "SELECT visitor_log.date_visited, visitor_log.time_In, visitor_log.time_Out, person.person_ID, person.last_Name, person.first_Name, person.middle_Name, student.Course, student.student_level
                                FROM visitor_log
                                INNER JOIN person ON visitor_log.person_ID = person.person_ID
                                INNER JOIN student ON visitor_log.person_ID = student.person_ID
                                WHERE visitor_log.date_visited = '2023-12-02'";
                        $query_run = mysqli_query($conn, $sql);
        
        
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $visitor)
                            {
                                
                                ?>
                                <tr>
                    
                    <td><?= $visitor['last_Name'], ", ",$visitor['first_Name'], " ",$visitor['middle_Name'];  ?></td>
                    <td><?= $visitor['Course'], " ",$visitor['student_level']; ?></td>
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
        
                      </tr>
                    </thead>
                    <tbody>
                  </table>