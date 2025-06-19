
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
                    <label>Enter Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" >
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Send OTP">
                </div>
            </form>
 </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/change_password.js"></script>

</body>
</html>
 