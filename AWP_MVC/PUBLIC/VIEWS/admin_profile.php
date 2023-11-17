<?php
include("../../CONFIG/connection.php");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta charset="UTF-8 /">
<link rel="stylesheet" href="../RESOURCES/CSS/admin.css">
<title>Admin Profile</title>


<link 
rel="stylesheet"

href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/
css/all.min.css" 
/>
</head>
<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
                <a href="dashboard1.php">
                    <i class="fas fa-tachometer-alt"></i>
                      <span>Dashboard</span>
                 </a>
            </li>
            <li>
            <li class="active">
                <a href="#">
                    <i class="fas fa-user"></i>
                      <span>Admin</span>
                 </a>
            </li>
            <li>
            <li class="logout">
                <a href="log_in.php">
                    <i class="fas fa-sign-out-alt"></i>
                      <span>Logout</span>
                 </a>
            </li>
        </ul>
    </div>
    <div class="main--content">
      <div class="header--wrapper">
      <div class="header">
      <img src="../../PUBLIC/RESOURCES/IMAGES/logo.png" alt="Avatar" class="sjcbi">
  <p class="split2">SAINT JOSEPH'S COLLEGE</p>
  <p class="split3">OF BAGGAO</p>
  <p class="split4">BAGGAO, CAGAYAN, PHILIPPINES</p>
</div>

<div class="user--info">      
        </div>
    </div> 

    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Admin Profile
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="image/avatar.png" alt
                                    class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <h3>Admin </h3>
                                    </label> &nbsp;
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <?php
    session_start();
    ?>
    <p style="color:red"><?php echo isset($_SESSION['msg1']) ? $_SESSION['msg1'] : ''; ?></p>
    <form name="chngpwd" action="" method="POST" onsubmit="return valid();"> 
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                            <div class="form-group">
                                    <label class="form-label">Account ID</label>
                                    <input type="password" name="Account_ID" class="form-control">
                                    </div>
                                    <div class="form-group">
                          <label class="form-label">Current password</label>
                                <div class="input-group">
                                <input type="password" name="Password" id="currentPassword" class="form-control" data-visible="false">
                                <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="currentPassword">
                                <i class="fas fa-eye"></i>
                                     </span>
                                        </div>
                                            </div>
                                                </div>
                                    <div class="form-group">
                         <label class="form-label">New password</label>
                                <div class="input-group">
                                <input type="password" name="npwd" id="newPassword" class="form-control" data-visible="false">
                                <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="newPassword">
                                <i class="fas fa-eye"></i>
                                    </span>
                                         </div>
                                             </div>
                                                </div>
                                    <div class="form-group">
                        <label class="form-label">Repeat new password</label>
                                <div class="input-group">
                                <input type="password" name="cpwd" id="repeatNewPassword" class="form-control" data-visible="false">
                                <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="repeatNewPassword">
                                <i class="fas fa-eye"></i>
                                        </span>
                                            </div>
                                                </div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <div class="text-right mt-3">
            <button type="submit" name="Submit" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="submit" class="btn btn-default">Cancel</button>
            <?php
    if (isset($_POST['Submit'])) {
       include("../../CONFIG/connection.php");

        $Account_ID = mysqli_real_escape_string($conn, $_POST['Account_ID']);
        $Password = isset($_POST['Password']) ? mysqli_real_escape_string($conn, $_POST['Password']) : '';
        $npwd = mysqli_real_escape_string($conn, $_POST['npwd']);
        $npwd = mysqli_real_escape_string($conn, $_POST['npwd']);
        $cpwd = mysqli_real_escape_string($conn, $_POST['cpwd']);

        $query = mysqli_query($conn, "SELECT Account_ID, Password FROM user_account WHERE Account_ID='$Account_ID' AND Password='$Password'");

        $num = mysqli_num_rows($query);
        if ($num > 0) {
            $conn = mysqli_query($conn, "UPDATE user_account SET Password='$npwd' WHERE Account_ID='$Account_ID'");
            $_SESSION['msg1'] = "Password Changed Successfully";
        } else {
            $_SESSION['msg1'] = "Password does not match";
        }
    }
    ?>

    

        </div>
          </div>
            </div>
             </div>
             
        
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
    
</body>
</html>


</body>
</html>


  