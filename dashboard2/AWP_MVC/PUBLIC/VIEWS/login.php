<?php
 include('../../CONFIG/DB_Configuration.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log In</title>
<link rel="stylesheet" type= "text/css" href="../RESOURCES/CSS/login.css"/>
</head>
<body style="background-image: url('..\RESOURCES\IMAGES\bg-image.jpg);">

<div class="log-in-card">
  <form class="log-in-form" method="post">
  <h4> SAINT JOSEPH'S COLLEGE OF BAGGAO</h4>
  <img src="..\RESOURCES\IMAGES\logo.png" img class="sjcbi">
      <div><input type="text" placeholder="Enter Email Address" name="Email_Address" required></div>
      <div class="log_in"><input type="Password" placeholder="Enter Password" name="Password" required></div>
      <button onclick="openForgotPasswordModal()">Forgot my Password!</button>
      <div class="button_login">
        <button type="submit" name="login">Login</button> 
      </div>
      <div class="form-item-other">
      <div class="checkbox"><input type="checkbox" id="checkbox" checked>
        <label>Keep me logged In</label></div>
      </div>
  </form>
</div>


<!-- Forgot Password Modal -->
<div class="modal" id="forgot-password-modal">
  <div class="modal-content">
    <span class="close" onclick="closeForgotPasswordModal()">&times;</span>
    <h2>Forgot Password</h2>
  
    <form method="post" onsubmit="resetPassword(); return false;">
      <div>
        <label for="Email_Address">Email Address</label><br>
        <input type="text" placeholder="" name="Email_Address" id="Email_Address" required>
      </div><br>
      <div>
        <label for="Password">New Password</label><br>
        <input type="password" placeholder="" name="Password" id="Password" required>
      </div><br>
      <div>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" placeholder="" name="confirm_password" id="confirm_password" required>
      </div>
      <input type="hidden" name="password" id="password" value="<?php echo $Password; ?>">
      <br>
<button id="button "type="submit" name="reset_password">Change Password</button>
</form>
    </form>
  </div>
</div>


<?php
 include('../../CONFIG/DB_Configuration.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    // Get user input
    $email = $_POST["Email_Address"];
    $newPassword = $_POST["Password"];

    // Validate email (you can add more validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email
        echo "Invalid email address";
        exit();
    }

    // Check if the email exists in your database (you need to implement this)
    // Assuming you have a user_account table with columns 'email' and 'password'
    $query = "SELECT * FROM user_account WHERE Email_Address = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Update the user's password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE user_account SET Password = '$newPassword' WHERE Email_Address = '$email'";
        mysqli_query($conn, $updateQuery);

        // Password updated successfully
        echo " ";
    } else {
        // Email not found in the database
        echo "Email not found";
    }
}
?>


<script>
// Function to open the Forgot Password modal
function openForgotPasswordModal() {
  document.getElementById("forgot-password-modal").style.display = "block";
}

// Function to close the Forgot Password modal
function closeForgotPasswordModal() {
  document.getElementById("forgot-password-modal").style.display = "none";
}

</script>


  <?php
    if (array_key_exists('login', $_POST)) {
      $Email_Address = $_POST['Email_Address'];
      $Password = $_POST['Password'];
      $select_user = "SELECT * FROM user_account WHERE `Email_Address` ='$Email_Address' and `Password` = '$Password'";
      $Login = $conn->query($select_user);
      if ($row = mysqli_fetch_object($Login)) {
        header("Location: dashboard2.php");
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
</div>
</script>
</body>
</html>

