<?php
session_start();
include_once "php/config.php";

if (!isset($_SESSION['otp'])) {
    header("Location: signup.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    if ($otp == $_SESSION['otp']) {
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $email = $_SESSION['email'];
        $password = md5($_SESSION['password']); // Use MD5 hashing

        $unique_id = rand(time(), 10000000);

        $sql = "INSERT INTO users (unique_id, fname, lname, email, password) VALUES ('$unique_id', '$fname', '$lname', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['otp']);
            $_SESSION['unique_id'] = $unique_id;
            header("Location: homepage.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to save user details. Please try again!";
        }
    } else {
        $_SESSION['error'] = "Invalid OTP. Please try again!";
    }
    header("Location: verify_otp.php");
    exit();
}
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url(images/verify.jpg);
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        .wrapper {
            border: 1px solid black;
            padding: 20px;
            border-radius: 15px;
            background-color: #ffffff70;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form {
            width: 100%;
        }
        header {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .field {
            margin-bottom: 15px;
        }
        .input label {
            display: block;
            margin-bottom: 5px;
        }
        .input input {
            width: 88%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button input {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button input:hover {
            background-color: #45a049;
        }
        .error-text {
            color: red;
            margin-bottom: 15px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <section class="form verify-otp">
            <header>Verify OTP</header>
            <form id="otpForm" action="verify_otp.php" method="POST" autocomplete="off">
                <div class="error-text"><?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?></div>
                <div class="field input">
                    <label>OTP</label>
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                </div>
                <div class="field button">
                    <input type="submit" value="Verify">
                </div>
            </form>
        </section>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorText = document.querySelector('.error-text');
            if (errorText.textContent.trim() !== "") {
                errorText.style.display = 'block';
            }
        });
    </script>
</body>
</html>
