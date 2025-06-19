<?php
session_start();
$loggedInUserId = $_SESSION['unique_id'];
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("Location: Landingpage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
    <title>Connectify</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    </style>
  </head>
  <body>
    <header>
      <div class="navbar">
        <nav>
          <div class="logoimg">
            <a href="index.php"><img src="./images/logo2.png" alt="" height="50px" /></a>
          </div>
          <div class="searchBar">
            <img src="./images/search.png" alt="" height="35px" />
            <input type="search" name="search" id="search" placeholder="Search for user" />
          </div>


          <div class="profilePic">
          <a href="notifications.php" class="material-icons">notifications</a>
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if (mysqli_num_rows($sql) > 0) {
              $row = mysqli_fetch_assoc($sql);
            }
            ?>
            <a href="profile.php"><img class="profilePic" src="php/profile_images/<?php echo $row['img']; ?>" alt="" width="40px" height="40px"></a>
          </div>
        </nav>
      </div>
    </header>
    <div id="userList">
      <!-- User list will be dynamically populated here -->
    </div>
    <div class="side">
       <aside class="sidebar">
      <ul class="links">
        <li>
          <span class="material-icons">home</span>
          <a href="homepage.php">Home</a>
        </li>
        <li>
          <span class="material-icons">explore</span>
          <a href="explore.php">Explore</a>
        </li>
        <li>
          <span class="material-icons">forum</span>
          <a href="users.php">Chats</a>
        </li>
        <li>
          <span class="material-icons">groups_3</span>
          <a href="connectify/index.html">Meet</a>
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
                    <strong>Only JPG, JPEG, and PNG images are allowed.</strong>
                   <br />
                   <textarea id="captionText" name="post_text" placeholder="Write a caption..."></textarea>
                   <button type="submit">Submit Post</button>
                  </form>
                </div>
              </div>  
    </div>
    <?php
    function getPost() {
        global $conn;
         $query = "SELECT posts.id, posts.post_img, posts.post_text, posts.created_at, posts.unique_id, users.fname, users.lname, users.img, users.unique_id 
          FROM posts
          JOIN users ON users.unique_id = posts.unique_id
          JOIN followers ON followers.user_id = posts.unique_id
          WHERE followers.follower_id = {$_SESSION['unique_id']}
          ORDER BY posts.created_at DESC"; 
        $run = mysqli_query($conn, $query);
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    $posts = getPost();
    ?>
    <div class="postbody">
      <div class="container">
        <h1>Posts</h1>
        <?php foreach ($posts as $post): ?>
        <div class="card">
          <img src="php/posts/<?php echo $post['post_img']; ?>" class="card-img-top" alt="Post Image">
          <div class="card-body">
            <h5 class="card-title">
              <a href="#" class="post-profile-pic" data-user-id="<?php echo $post['unique_id']; ?>">
                <img src="php/profile_images/<?php echo htmlspecialchars($post['img']); ?>" alt="Profile Picture">
              </a> 
              <?php echo $post['fname'] . ' ' . $post['lname']; ?>
            </h5>
            <p class="card-text"><?php echo $post['post_text']; ?></p>
            <div class="actions">
              <span id="getpostid" hidden><?php echo $post['id']; ?></span>
              <a class="material-icons like-icon" id="like-icon" data-post-id="<?php echo $post['id']; ?>">
                <?php
                $sql2 = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$post['id']} AND unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql2) > 0) {
                  echo "favorite";
                } else {
                  echo "favorite_border";
                }
                $likes_sql = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$post['id']}");
                $likes_array = [];
                while ($likec = mysqli_fetch_assoc($likes_sql)) {
                  $likes_array[] = $likec;

                }
                ?>
              </a>
              <span class="post-like-count" data-post-id="<?php echo $post['id']; ?>"><?php echo count($likes_array); ?></span>
              <a class="material-icons comment-icon" data-post-id="<?php echo $post['id']; ?>">chat_bubble_outline</a>
            
               <a class="material-icons share-icon" data-post-id="<?php echo $post['id']; ?>">send</a> 
               <!-- Modal for comments -->
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
            
              <div class="share-modal" id="ShareModal-<?php echo $post['id']; ?>">
                <div class="common">
                  <div class="share-list">

                  </div> 
                  <div class="share-buttons">
    <!-- Facebook Share Button -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/internship/chatapp/single_post.php?post_id=<?php echo $post['id']; ?>" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Share on Facebook" />
    </a>

    <!-- WhatsApp Share Button -->
    <a href="https://api.whatsapp.com/send?text=Check out this post! http://localhost/internship/chatapp/single_post.php?post_id=<?php echo $post['id']; ?>" target="_blank"
      id="Whatsapp" >
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="Share on WhatsApp" />
    </a>

    <!-- Instagram Share Button -->
    <a href="https://www.instagram.com/?url=http://localhost/internship/chatapp/single_post.php?post_id=<?php echo $post['id']; ?>" target="_blank" >
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Share on Instagram" />
    </a>

    <!-- X (Twitter) Share Button -->
    <a href="https://twitter.com/intent/tweet?url=http://localhost/internship/chatapp/single_post.php?post_id=<?php echo $post['id']; ?>&text=Check out this post!" target="_blank">
        <img src="./images/twitter.png" alt="Share on Twitter" />
    </a>
</div>

                  <button class="share-cancel" data-post-id="<?php echo $post['id']; ?>">Cancel</button>
                </div>
              </div>
            </div>
            <p class="card-text"><small class="text-muted"><?php echo $post['created_at']; ?></small></p>
          </div>

          <hr>
          <hr>
          
        </div>
            
       <?php endforeach; ?>
       
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          const loggedInUserId = "<?php echo $_SESSION['unique_id']; ?>";
          console.log('Logged In User ID:', loggedInUserId);
          document.querySelectorAll('.post-profile-pic').forEach(pic => {
              pic.addEventListener('click', function() {
                  const userId = pic.getAttribute('data-user-id');
                  console.log('Clicked User ID:', userId);
                  if (userId === loggedInUserId) {
                      console.log('Redirecting to own profile page');
                      window.location.href = "profile.php"; // Redirect to the user's own profile page
                  } else {
                      console.log('Redirecting to others profile page');
                      window.location.href = "others_profile_page.php?user_id=" + userId; // Redirect to the other user's profile page
                  }
              });
          });


      });
    </script>
    
  <script src="javascript/post.js?v=<?time()?>"></script>
  <script src="javascript/like.js"></script> 
  <script src="javascript/comment.js"></script> 
    <script src="javascript/share-post.js"></script> 
  <script src="javascript/search_users.js"></script>