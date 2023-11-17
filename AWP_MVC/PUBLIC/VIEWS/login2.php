<!DOCTYPE html>
<html lang="en">
<?php
session_start();

include('../../CONFIG/connection.php');
ob_start();
if (!isset($_SESSION['system'])) {
	$system = $conn->query("SELECT * FROM user_account limit 1")->fetch_array();
	foreach ($system as $k => $v) {
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link rel="stylesheet" href="../RESOURCES/CSS/login2.css">
	<link rel="icon" href="../assets/img/sjcblogo.png" type="image/png">


	<?php
	if (isset($_SESSION['login_id']))
		header('location:index.php?page=home');

	?>

</head>


<body>
<div class="modal">
  <div class="login-container">
    <form class="log-in-form" method="post" onsubmit="return validateForm()">

	<div class="container">

		<main id="main" class=" bg-dark">
			<div id="login-left">
			</div>
			<div id="login-right">
				<div class="card col-md-8">
					<div class="card-header">
						<h3 style="color: black; text-align: center; font-weight: 550;">Login</h3>
					</div>
					<div class="card-body">
						<form id="login-form">
							<div class="form-group">
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
    </form>
      </div>

							<a href="../index.php" class="btn btn-secondary rounded-0" style="float: right; width: 100px;">Cancel</a>
					</div>


					</form>

				</div>
			</div>
	</div>


	</main>

	</div>


	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function (e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function (resp) {
				if (resp == 1) {
					location.href = 'index.php?page=home';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>
<style>


body {
  font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  background-color:#f5f5f5;
}

.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5;
}

.login-container {
  width: 450px;
  height: 500px;
  padding: 20px;
  background: linear-gradient(145deg, #fff, #fff);
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  text-align: center;
  
}

input[type=text],
input[type=password] {
  width: 95%;
  padding: 12px;
  margin: 8px 0;
  display: block;
  border: 1px solid #ccc;
  border-radius: 10px;
}
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}
.button-container {
  display: flex;
  justify-content: space-between;
  
}

button {
  width: 15%;
  padding: 10px;
  border: none;
  cursor: pointer;
  background: linear-gradient(145deg, #04AA6D, #04855e);
  color: white;
  border-radius: 5px;
  transition: background 0.3s;
  margin: 20px;
}
.button-container{
justify-content: center;


}
button:hover {
  background: linear-gradient(145deg, #04855e, #046748);
}


.button-psw.psw {
  margin-top: 10px;
}
.error-modal {
  width: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: none; /* Initially hide the error modal */
  z-index: 1; /* Ensure it appears above other content */
  opacity: 0; /* Start with 0 opacity */
  animation: fadeIn 0.2s ease-in-out forwards;
   /* Smooth fade-in transition */
  /* Add other styling properties as needed */
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}


.error-box {
	margin: auto;
  background: linear-gradient(145deg, #fff, #fff);
  border: 1px solid #f8f5f5;
  padding: 10px;
  text-align: center;
  color: #130103;
  position: fixed;
  top: 50%; /* Center vertically */
  left: 50%; /* Center horizontally */
  transform: translate(-50%, -50%); /* Center both horizontally and vertically */
  width: 100%;
  max-width: 400px;
  z-index: 20;
  border-radius: 5px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  animation: fadeIn 5s ease-in-out forwards;
  animation: fadeOut 10s ease-in-out forwards;

}
  
  .error-modal {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: none; /* Initially hide the error modal */
  z-index: 1; /* Ensure it appears above other content */
  /* Add other styling properties as needed */
}






.ok-button {
  background-color: #28a745;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  color: #fff;
  font-weight: bold;
  transition: background-color 0.6s;
}

.ok-button:hover {
  background-color: #218838;
}

@keyframes fadeInOut {
  0%, 100% {
    transform: translateY(-100%);
    opacity: 0;
  }
  10%, 90% {
    transform: translateY(0);
    opacity: 1;
  }
}

</style>
</html>