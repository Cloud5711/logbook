<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../RESOURCES/CSS/admin.css">

    <title>ADMIN</title>
</head>
<body>
        <div class="container light-style flex-grow-2 container-p-y">
        <h4 class="font-weight-bold mb-4"><br><br><br><br><br>
         Admin Profile
        </h4>
        <div class="card">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group list-group-flush account-settings-links">
                     <img style="size:1px;" src="../../PUBLIC/RESOURCES/IMAGES/avatar.png" class="avatar"> 
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="account-general">
                            <div class="card-body mb-0">
                                <div class="media-body mb-0">
                                  
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                   
                                 
                                </div>
                                <div class="form-group">
                                    
                                </div>
                            </div>

    <p style="color:red"><?php echo isset($_SESSION['msg1']) ? $_SESSION['msg1'] : ''; ?></p>
    <form name="chngpwd" action="" method="POST" onsubmit="return valid();"> 
                        </div>
                        <div class="tab-pane fade active show" id="account-change-password">
                            <div class="card-body pb-2">
                            <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <input type="text" name="Email_Address" class="form-control">
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
                    <div class="text-left mt-4 mb-4 col-md-3">
            <button type="submit" name="Submit" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="submit" class="btn btn-default">Cancel</button>
            <?php
    if (isset($_POST['Submit'])) {
        include('../../CONFIG/DB_Configuration.php');

        $Email_Address = mysqli_real_escape_string($conn, $_POST['Email_Address']);
        $Password = isset($_POST['Password']) ? mysqli_real_escape_string($conn, $_POST['Password']) : '';
        $npwd = mysqli_real_escape_string($conn, $_POST['npwd']);
        $npwd = mysqli_real_escape_string($conn, $_POST['npwd']);
        $cpwd = mysqli_real_escape_string($conn, $_POST['cpwd']);

        $query = mysqli_query($conn, "SELECT Email_Address, Password FROM user_account WHERE Email_Address='$Email_Address' AND Password='$Password'");

        $num = mysqli_num_rows($query);
        if ($num > 0) {
            $conn = mysqli_query($conn, "UPDATE user_account SET Password='$npwd' WHERE Email_Address='$Email_Address'");
            $_SESSION['msg1'] = " ";
        } else {
            $_SESSION['msg1'] = " ";
        }
    }
    ?>
        </div>
          </div>
            </div>
             </div>

    </div>

</body>
</html>
