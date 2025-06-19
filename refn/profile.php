<?php

include 'php/profile_page.php'; 
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("Location: homepage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
  </style> 
  <link rel="stylesheet" href="profile_page.css">
</head>
<style>
  
    
</style>
<body>

  <div class="main">
    <aside class="sidebar">
      <div class="logo">
        <a href="index.php"><img src="./images/logo2.png" alt=""></a>
      </div>
      <ul class="links">
        <li>
          <span class="material-icons">home</span>
          <a href="homepage.php">Home</a>
        </li>
        <li>
          <span class="material-icons">explore</span>
          <a href="#">Explore</a>
        </li>
        <li>
          <span class="material-icons">forum</span>
          <a href="users.php">Chats</a>
        </li>
        <li>
          <span class="material-icons">groups_3</span>
          <a href="#">Meet</a>
        </li>
        <li>
          <span class="material-icons">add</span>
           <a href="#" data-bs-target="#addpost" id="openModalBtn">Create Post</a>

        </li>
        <hr>
        <li>
          <span class="material-icons">settings</span>
          <a href="settings.php">Settings</a>
        </li>
        <li>
          <span class="material-icons">logout</span>
           <a href="php/logout.php?logout_id=<?php echo $_SESSION['unique_id']; ?>" class="btn">Logout</a>
        </li>
      </ul>
    </aside>
        <div id="addpost" class="modal">
           <div class="modal-content">
             <span class="close">&times;</span>
             <h2>Create a Post</h2>
              <img src="" style="display:none" id="post_img">
             <form id="postForm" method="post" action="php/post.php?addpost" enctype="multipart/form-data">
               <input type="file" name="post_img" id="select_post_image" required /><br />
               <br />
               <textarea id="captionText" name="post_text" placeholder="Write a caption..."></textarea>
               <button type="submit">Submit Post</button>
              </form>
            </div>
          </div>
    <div class="area">
      <div class="a1">
        <div class="user-img">      
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
            $followers_sql = mysqli_query($conn, "SELECT * FROM followers WHERE user_id ={$_SESSION['unique_id']} ");
             $followers = [];
             while ($follower = mysqli_fetch_assoc($followers_sql)) {
                 $followers[] = $follower;
             }
          
             $followings_sql = mysqli_query($conn, "SELECT * FROM followers WHERE follower_id = {$_SESSION['unique_id']} ");
             $followings = [];
             while ($following = mysqli_fetch_assoc($followings_sql)) {
                $followings[] = $following;
             }
            
          ?>
          <img class="profilePic" src="php/profile_images/<?php echo $row['img']; ?>" alt="" width="40px" height="40px">
            
          </div>
        <div class="user-info">
          <h2><?php echo $row['fname'] . ' ' . $row['lname']; ?></h2>
          <div class="numbers">
            <div class="num">
              <span><?php echo count($posts); ?></span>
              <span>posts</span>
            </div>
            <div class="num">
              <span><?php echo count($followings); ?></span>
              <span>following</span>
            </div>
            <div class="num">
              <span><?php echo count($followers); ?></span>
              <span>followers</span>
            </div>
          </div>
          <div class="bio">
           <p><?php echo $row['bio']; ?></p>
          </div>
          <a href="user-edit.php"><button class="edit"> Edit Profile</button></a>
        </div>
      </div>
      <hr>
      <div class="title">
        <span class="material-icons tab active" id="postsTab">grid_on</span>
        <span class="material-icons tab" id="reelsTab">video_library</span>
      </div>
      <div class="content">
        <div class="posts active" id="postsSection">
          <?php foreach ($posts as $post): ?>
          <div class="post" data-post-id="<?php echo $post['id']; ?>" >
            <img src="php/posts/<?php echo $post['post_img']; ?>" alt="Post Image">
            <p><?php echo htmlspecialchars($post['post_text']); ?></p>
            <div class="actions">
              <span class="material-icons">favorite_border</span>
              <span class="material-icons">chat_bubble_outline</span>
               <div class="dropdown">
                
                 <span class="material-icons more-options">more_vert</span>
                 
                  <div class="dropdown-content">
                  <a href="#" class="delete-post"> Delete </a>
                 </div>
                
               </div>
            
            </div>
            <small>Posted on <?php echo $post['created_at']; ?></small>
            </div>
          <?php endforeach; ?>
        </div>
        <?php
    function getReels() {
        global $conn;
        $query = "SELECT * FROM reels WHERE user_id = {$_SESSION['unique_id']}";  
        $run = mysqli_query($conn, $query);
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    $reels = getReels();
    ?>
        <div class="reels" id="reelsSection">
          <?php foreach ($reels as $reel): ?>
          <div class="reel" data-reel-id="<?php echo $reel['id']; ?>">
            <div class="reel_video">
            <video src="<?php echo $reel['video_path']; ?>" class="reel-video"></video>
            </div>
            <div class="reel_details">
              <div class="reel_caption">
               <p><?php echo htmlspecialchars($reel['caption']); ?></p>
              </div>

           <div class="reel_actions">
              <span class="material-icons">favorite_border</span>
              <span class="material-icons">chat_bubble_outline</span>
               <!-- <div class="dropdown">
                 <span class="material-icons more-options">more_vert</span>
                 <div class="dropdown-content">
                   <a href="#" class="delete-reel">Delete</a>
                 </div>
               </div> -->
            </div>
            <div class="post_time">
            <small>Posted on <?php echo $reel['created_at']; ?></small>
             </div>
             </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="javascript/reels.js?v=<?time()?>"></script>
  <script src="javascript/post.js?v=<?time()?>"></script>
  <script src="javascript/delete_post.js?v=<?time()?>"></script>
  <script src="javascript/user-edit.js?v=<?time()?>"></script>
</body>

</html>
