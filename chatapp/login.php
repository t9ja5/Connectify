<?php
session_start();
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
</style>
<body>
    <div class="SLwrapper">
        <section class="form login">
            <header><img src="./images/Logo2.png" alt="" height="50px"></header>
            <form action="#" method="POST" autocomplete="off">
                <div class="error-text"></div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email">
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Continue">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="signup.php">Signup now</a></div>
            <div class="link"><a href="change_password.php" class="forgetp">forgot password?</a></div>
 </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>
</html>
