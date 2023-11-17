<?php
include('../../CONFIG/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../RESOURCES/CSS/login.css">
  <title>Login</title>
  
</head>

<body>
<div class="modal">
  <div class="login-container">
    <form class="log-in-form" method="post" onsubmit="return validateForm()">

      <div class="imgcontainer">
        <img src="../../PUBLIC/RESOURCES/IMAGES/logo.png" alt="Avatar" class="avatar">
      </div>
      <label for="Account_ID"><b>User Account</b></label>
      <input type="text" placeholder="Enter Account ID" name="Account_ID" required>
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="Password" required>
      
      <div class="button-psw">
        <span class="psw"><a href="pass_modal.php">Forgot password?</a></span>
      </div>
      
      <div class="button-container">
        <button type="submit" name="login">Login</button>
        <button type="submit">Cancel</button>
      </div>
      <div class="extras">
      </div>
    </form>
    <div class="error-modal" id="error-modal">
      <div class="error-box">
        <p>The username and password you entered did not match the records.</p>
        <button class="ok-button" onclick="closeErrorModal()">OK</button>
  </div>
  <?php
    if (array_key_exists('login', $_POST)) {
      $Account_ID = $_POST['Account_ID'];
      $Password = $_POST['Password'];
      $select_user = "SELECT * FROM user_account WHERE `Account_ID` ='$Account_ID' and `Password` = '$Password'";
      $Login = $conn->query($select_user);
      if ($row = mysqli_fetch_object($Login)) {
        header("Location: dashboard.php");
      } else {
        // Display error message as a modal with an "OK" button
        echo '<div class="error-modal" id="error-modal">
          <div class="error-box">
            <p>The username and password you entered did not match the records.</p>
            <button class="ok-button" onclick="closeErrorModal()">OK</button>
          </div>
        </div>';
        echo '<script>
          document.getElementById("error-modal").style.display = "block";
          function closeErrorModal() {
            document.getElementById("error-modal").style.display = "none";
          }
        </script>';
      }
    }
  ?>
  <script src="script.js"></script>
  



</div>
</body>
</html>
<script src="../RESOURCES/JS/login.js"></script>;
