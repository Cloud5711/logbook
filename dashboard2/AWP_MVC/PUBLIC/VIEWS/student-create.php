<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Create</title>
</head>
<body>
  
    <div class="container mt-1">

        <?php include('message.php'); ?>
        <br><br><br><br>
        <div class="row">
            <div class="float-right col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Attendance 
                            <a href="dashboard2.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">

                            <div class="mb-3">
                                <label>person ID</label>
                                <input type="text" name="person_ID" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Date</label>
                                <input type="date" name="date_visited" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Time In</label>
                                <input type="time" name="time_In" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Time Out</label>
                                <input type="time" name="time_Out" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_record" class="btn btn-primary">Save Record</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


  </body>
</html>