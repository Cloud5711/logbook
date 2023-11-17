<?php
session_start();
include('../../CONFIG/connection.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student Create</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Attendance 
                            <a href="code.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">

                            <div class="mb-3">
                                <label>person ID</label>
                                <input type="text" name="person_ID" class="">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
