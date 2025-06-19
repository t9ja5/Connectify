<?php
session_start();
include_once "config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $otp = rand(100000, 999999);

    // Save OTP and user details in session
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['otp'] = $otp;

    // Send OTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'connectifyyyy@gmail.com';
        $mail->Password = 'hizeucxlidyhychc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('connectifyyyy@gmail.com', 'Connectify');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification Code';
        $mail->Body = 'Your verification code is: <b>'.$otp.'</b>';

        $mail->send();
        header("Location: ../verify_otp.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

 
?>
