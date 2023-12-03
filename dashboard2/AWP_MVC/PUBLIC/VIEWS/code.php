<?php
session_start();
include('../../CONFIG/DB_Configuration.php');

if(isset($_POST['save_record']))
{
    $person_ID = mysqli_real_escape_string($conn, $_POST['person_ID']);
    $date_visited = mysqli_real_escape_string($conn, $_POST['date_visited']);
    $time_In = mysqli_real_escape_string($conn, $_POST['time_In']);
    $time_Out = mysqli_real_escape_string($conn, $_POST['time_Out']);
  

    $query = "INSERT INTO visitor_log (person_ID, date_visited, time_In, time_Out) VALUES ($person_ID, '$date_visited', '$time_In', '$time_Out')";

    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Recorded Successfully";
        header("Location: dashboard2.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Error";
        header("Location: student-create.php");
        exit(0);
    }
}
?>