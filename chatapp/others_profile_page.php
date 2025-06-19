<?php
include_once "php/config.php";
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("Location: homepage.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Fetch user details from the database
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$user_id'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);

        // Fetch posts of the user
        $posts_sql = mysqli_query($conn, "SELECT * FROM posts WHERE unique_id = '$user_id'");
        $posts = [];
        while ($post = mysqli_fetch_assoc($posts_sql)) {
            $posts[] = $post;
        }

        // Fetch reels of the user
        $reels_sql = mysqli_query($conn, "SELECT * FROM reels WHERE user_id = '$user_id'");
        $reels = [];
        while ($reel = mysqli_fetch_assoc($reels_sql)) {
            $reels[] = $reel;
        }
    } else {
        echo "User not found.";
        exit();
    }
} else {
    header("Location: homepage.php");
    exit();
}

// Fetch followers and followings
$followers_sql = mysqli_query($conn, "SELECT * FROM followers WHERE user_id ={$row['unique_id']} ");
$followers = [];
while ($follower = mysqli_fetch_assoc($followers_sql)) {
    $followers[] = $follower;
}

$followings_sql = mysqli_query($conn, "SELECT * FROM followers WHERE follower_id = {$row['unique_id']} ");
$followings = [];
while ($following = mysqli_fetch_assoc($followings_sql)) {
    $followings[] = $following;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['fname'] . ' ' . $row['lname']; ?>'s Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="others_profile_page.css">
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
    </style>
</head>
<body>
    <div class="main">
      <aside class="sidebar">
        <div class="logo">
          <a href="index.php"><img src="./images/logo2.png" alt=""></a>
        </div>
        <ul class="links">
          <li><span class="material-icons">home</span><a href="homepage.php">Home</a></li>
          <li><span class="material-icons">explore</span><a href="explore.php">Explore</a></li>
          <li><span class="material-icons">forum</span><a href="users.php">Chats</a></li>
          <li><span class="material-icons">groups_3</span><a href="#">Meet</a></li>
          <li><span class="material-icons">add</span><a href="#" id="openModalBtn">Create Post</a></li>
         
          <hr>
          <li><span class="material-icons">settings</span><a href="settings.php">Settings</a></li>
          <li><span class="material-icons">logout</span>
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
                   <input type="file" name="post_img" id="select_post_image" required />
                   <br />
                    <strong>Only JPG, JPEG, and PNG images are allowed.</strong>
                   <textarea id="captionText" name="post_text" placeholder="Write a caption..."></textarea>
                   <button type="submit">Submit Post</button>
                  </form>
                </div>
              </div>
      <div class="area">
        <div class="a1">
          <div class="user-img">
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
              <p><?php echo htmlspecialchars($row['bio']); ?></p>
            </div>
            <div class="buttons">
              <button class="follow_button" id="follow-btn">
              <?php 
// Query to check follow status
$sql2 = mysqli_query($conn, "SELECT is_follow FROM followers WHERE user_id = {$row['unique_id']} AND follower_id = {$_SESSION['unique_id']}");

if (!$sql2) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($sql2) > 0) {
        $someone = mysqli_fetch_assoc($sql2);
        if ($someone['is_follow'] == 1) {
            echo "Unfollow";
        } else {
            echo "Requested";
        }
    } else {
        echo "Follow";
    }
}
?>

              </button>
              <button class="chat-button" id="chat-btn" > 
              <a href="chat.php?user_id=<?php echo $row['unique_id']; ?>" >
                  Chat
              </a>
              </button>
              <span hidden id="getuniqueid"><?php echo $row['unique_id']; ?></span>
            </div>
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
            <div class="actions" >
              <a class="material-icons like-icon" data-post-id="<?php echo $post['id']; ?>">
                <?php
                $sql2 = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$post['id']} AND unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql2) > 0) {
                  echo "favorite";
                } else {
                  echo "favorite_border";
                }
                $post_likes_sql = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$post['id']}");
                $post_likes_array = [];
                while ($likec = mysqli_fetch_assoc($post_likes_sql)) {
                  $post_likes_array[] = $likec;
                }

                ?>
                </a>
                <span class="post-like-count" data-post-id="<?php echo $post['id']; ?>">
                <?php 
                  echo count($post_likes_array); 
                  $post_likes_array = [];
                ?>
              
                </span>
                <a class="material-icons comment-icon" data-post-id="<?php echo $post['id']; ?>">chat_bubble_outline</a>
                <div id="commentsModal-<?php echo $post['id']; ?>" class="modal comments-modal">
                <div class="modal-content">
                  <div class="comments-container">
                    <div class="comments-list" data-post-id="<?php echo $post['id']; ?>">
                      <!-- Existing comments will be dynamically added here -->
                    </div>
                    <div class="add-comment">
                      <textarea class="comment-text" placeholder="Write a comment..." data-post-id="<?php echo $post['id']; ?>"></textarea>
                      <button class="submit-comment" data-post-id="<?php echo $post['id']; ?>">Comment</button>
                      <button class="comment-cancel" data-post-id="<?php echo $post['id']; ?>">Cancel</button>

                    </div>
                  </div>
                </div>
              </div>
              <?php 
                  $comment_sql = mysqli_query($conn, "SELECT * FROM comments WHERE post_id = {$post['id']} ");
                  $reel_commnets_array = [];
                  while ($comment = mysqli_fetch_assoc($comment_sql)) {
                      $reel_comments_array[] = $comment;
                  }
                  ?>
            </div>
            <small>Posted on <?php echo $post['created_at']; ?></small>
            </div>
          <?php endforeach; ?>
        </div>

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
              <span class="material-icons  reel-like-icon" data-post-id="<?php echo $reel['id']; ?>">                
                <?php
                $sql3 = mysqli_query($conn, "SELECT * FROM likes WHERE reel_id = {$reel['id']} AND unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql3) > 0) {
                  echo "favorite";
                } else {
                  echo "favorite_border";
                }
                $reel_likes_sql = mysqli_query($conn, "SELECT * FROM likes WHERE reel_id = {$reel['id']}");
                $reel_likes_array = [];
                while ($likec = mysqli_fetch_assoc($reel_likes_sql)) {
                  $reel_likes_array[] = $likec;
                }
                ?>
                </span>
                <span class="reel-like-count" data-post-id="<?php echo $reel['id']; ?>" >
                  <?php 
                    echo count($reel_likes_array);                 
                    $reels_likes_array = [];
                  ?>
                </span>

              <a class= "material-icons reel-comment-icon" data-post-id="<?php echo $reel['id']; ?>">chat_bubble_outline</a>
                <div id="reel-commentsModal-<?php echo $reel['id']; ?>" class="modal reel-comments-modal">
                <div class="reel-modal-content">
                  <div class="comments-container">
                    <div class="reel-comments-list" data-post-id="<?php echo $reel['id']; ?>">
                      <!-- Existing comments will be dynamically added here -->
                    </div>
                    <div class="reel-add-comment">
                      <textarea class="reel-comment-text" placeholder="Write a comment..." data-post-id="<?php echo $reel['id']; ?>"></textarea>
                      <button class="submit-reel-comment" data-post-id="<?php echo $reel['id']; ?>">Comment</button>
                      <button class="reel-comment-cancel" data-post-id="<?php echo $reel['id']; ?>">Cancel</button>

                    </div>
                  </div>
                </div>
              </div>
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
  <script src="javascript/post.js?v=<?time()?>"></script>
  <script src="javascript/reels.js?v=<?time()?>"></script>
  <script src="javascript/delete_post.js?v=<?time()?>"></script>
  <script src="javascript/user-edit.js?v=<?time()?>"></script>
  <script src="javascript/comment.js"></script> 
  <script src="javascript/like.js?v=<?time()?>"></script> 
  <script src="javascript/reel-like.js"></script> 
  <script src="javascript/reel-comment.js"></script> 
  <script src="javascript/follow.js"></script>  
</body>

</html>
