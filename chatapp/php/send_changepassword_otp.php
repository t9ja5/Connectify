<?php
session_start();
include_once "config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if(!empty($email)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){
            $otp = rand(100000, 999999);
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $otp;

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
                $mail->Subject = 'Change Password Code';
                $mail->Body = 'Your code is: <b>'.$otp.'</b>';

                $mail->send();
                echo "success";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
        }else{
            echo "$email - This email not Exist!";
        }
    }else{
        echo "All input fields are required!";
    } 
}

?>
