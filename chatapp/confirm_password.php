
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
                    <label>Enter New Password</label>
                    <input type="password" id="newpassword" name="newpassword" placeholder="Enter your new Password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <label>Confirm Password</label>
                    <input type="password" id="password" name="password" placeholder="Confirm your password">
                    <i class="fas fa-eye" id="eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Continue">
                </div>
            </form>
 </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/confirm_password.js"></script>

</body>
</html>
