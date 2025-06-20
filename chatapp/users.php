<?php
session_start();
include_once "php/config.php";

if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
}

?>
<style>
  .content img{
    border-radius:50px;
    object-fit:cover;
  }
</style>

<?php include_once "header.php"; ?>


  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <img src="php/profile_images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
       <a href="homepage.php" class="logout">Back</a>
        <!-- <a href="php/logout.php?logout_id= <?php echo $row['unique_id']; ?>" class="logout">Back</a> -->
      </header>
      <div class="search">
        <span type="search" class="text">Search an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
