<!-- 
<style>
    body {
        background: url('./images/background.jpg');
    }
    header {
        border-radius: 0px;
        display: flex;
        justify-content: center;
    }
    .wrapper img {
        /* filter:invert(1); */
    }
    .wrapper {
        /* color:white; */
        /* backdrop-filter: blur(10px);  */
        background-color: #ffffff;
        font-weight: 600;
        /* background: #000000bf;
            backdrop-filter: blur(7px);   */
        box-shadow: 20px 19px 10px 4px rgb(0 0 0 / 56%);
    }
</style>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header><img src="./images/Logo2.png" alt="" height="50px"></header>
            <form id="signupForm" action="php/send_otp.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" required>
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Continue">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>

    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html> -->


<?php
session_start();
include_once "php/config.php";
if (isset($_SESSION['unique_id'])) {
    header("Location: homepage.php");
    exit();
}
?>
<?php include_once "header.php"; ?>
<style>
    body {
        background: url('./images/background.jpg');
    }
    header {
        border-radius: 0px;
        display: flex;
        justify-content: center;
    }
    .wrapper img {
        /* filter:invert(1); */
    }
    .wrapper {
        /* color:white; */
        /* backdrop-filter: blur(10px);  */
        background-color: #ffffff;
        font-weight: 600;
        /* background: #000000bf;
            backdrop-filter: blur(7px);   */
        box-shadow: 20px 19px 10px 4px rgb(0 0 0 / 56%);
    }
</style>
<body>
    <div class="SLwrapper">
        <section class="form signup">
            <header><img src="./images/Logo2.png" alt="" height="50px"></header>
            <form id="signupForm" action="php/send_otp.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" required>
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Continue">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
      <script>
       document.getElementById('signupForm').addEventListener('submit', function(event) {
  const submitButton = document.querySelector('.field.button input');
  submitButton.disabled = true;
  submitButton.value = 'Processing...';
  
  // Optional: Prevent the default form submission for demonstration
  // event.preventDefault();
});

    </script>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>
