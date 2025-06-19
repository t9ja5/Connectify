<?php
session_start();
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // $profile_image = $_FILES['profile_image'];

    // Validate uploaded file
    if ($profile_image['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $profile_image['tmp_name'];
        $image_name = $profile_image['name'];
        
        // Store data in session
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['image'] = $image_name;
        $_SESSION['tmp_name'] = $tmp_name;

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;

        // Send OTP to email
        sendCode($email, "OTP Verification", $otp);

        // Redirect to verify page
        header("Location: ../verify_email.php");
        exit();
    } else {
        echo "Failed to upload profile image. Error code: " . $profile_image['error'];
    }
}
?>
