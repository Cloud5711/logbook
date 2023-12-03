<?php
include('../../CONFIG/DB_Configuration.php'); // Include your database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resetEmail = $_POST['reset_email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the input data
    if (empty($resetEmail) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields must be filled out.";
        exit();
    }

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
        exit();
    }

    // Check if the email and Password are valid in the user_account table
    $Password = $_POST['Password']; // Assuming you're passing the Password as a hidden field in the form
    $checkTokenQuery = "SELECT * FROM user_account WHERE Email_Address = '$resetEmail' AND Password = '$Password' AND expires_at > NOW()";
    $result = $conn->query($checkTokenQuery);

    if ($result->num_rows > 0) {
        // Token is valid, update the user's password in the users table
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updatePasswordQuery = "UPDATE user_account SET password = '$hashedPassword' WHERE Email_Address = '$resetEmail'";
        $conn->query($updatePasswordQuery);

        // Delete the used Password from the user_account table
        $deleteTokenQuery = "DELETE FROM user_account WHERE Email_Address = '$resetEmail' AND Password = '$Password'";
        $conn->query($deleteTokenQuery);

        echo "Password reset successful!";
    } else {
        echo "Invalid or expired Password. Please try the password reset process again.";
    }
} else {
    // Handle other HTTP methods if needed
    echo "Invalid request method.";
}
?>
