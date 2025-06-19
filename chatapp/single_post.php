<?php
session_start();
include_once "php/config.php";

if (!isset($_SESSION['unique_id'])) {
    header("Location: Landingpage.php");
    exit();
}

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$post_id = mysqli_real_escape_string($conn, $_GET['post_id']);
$query = "SELECT posts.id, posts.post_img, posts.post_text, posts.created_at, posts.unique_id, users.fname, users.lname, users.img, users.unique_id 
FROM posts
JOIN users ON users.unique_id = posts.unique_id
WHERE posts.id = $post_id "; 
$sql = mysqli_query($conn, $query);

if ($sql) {
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
    } else {
        header("Location: homepage.php");
        exit();
    }
} else {
    // Handle SQL query error
    echo "Error: " . mysqli_error($conn);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
    <title>Connectify</title>

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    </style>
</head> 
<style>
    .postbody {
     background-color: #f8f9fa;
     display: flex;
     justify-content: center;
     align-items: center;
     min-height: 100vh;
     margin: 0;
     flex-direction: column;
 }

 .container {
     background-color: #ffffff;
     padding: 20px;
     border-radius: 10px;
     box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
     width: 100%;
     max-width: 600px;
     margin: 20px 0;

     h5 {
         margin-top: 5px;

         img {
             width: 40px;
             height: 40px;
             border-radius: 50%;
             margin-right: 10px;
             object-fit: cover;
         }
     }

     h1 {
         text-align: center;
     }
 }

 .card {
     border: none;
     border-radius: 10px;
     overflow: hidden;
     margin-bottom: 20px;
 }

 .card img {
     width: 100%;
     height: auto;
     object-fit: contain;
     border-bottom: 1px solid #eaeaea;
 }

 .card-body {
     padding-top: 5px;
     padding: 15px;
 }

 .card-title {
     margin-bottom: 5px;
     font-size: 1.5rem;
     font-weight: bold;
     display: flex;
     align-items: center;
 }

 .card-text {
     margin-bottom: 5px;
     color: #6c757d;
     font-size: 18px;
 }

 .text-muted {
    color: #000000a6 !important;
 }

 hr {
     /* height: 1px; */
     background-color: #eaeaea;
     margin: 0;
     margin-top: 10px;
     margin-bottom: 10px;
 }

 .actions {
     display: flex;
     justify-content: flex-end;
     width: 100%;
    padding: 10px;
        text-decoration: none;
   
 }

 .actions a {
     margin-left: 10px;
     cursor: pointer;
    font-size: 30px;
    text-decoration: none;
    color: black;
 }
 .comment {
    display: flex;
    align-items: flex-start;
    border-radius: 20px;
     background-color: #09090932;
     padding: 10px;
    margin-bottom: 10px;
}
.comments-list{
    height: 320px;
        overflow: scroll;
        overflow-x: hidden;
}
.comment img {
    object-fit: cover;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.comment-content {
    max-width: 80%;
}

.comments-modal {
    display: none;

    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.comments-modal .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 20px;
}

.add-comment textarea {
    width: 100%;
    margin-top: 10px;
}

.add-comment button {
    margin-top: 10px;
        padding: 10px;
        border: none;
        border-radius: 10px;
        background: black;
        color: white;
    }

.add-comment button:hover{
    background-color: #0202023f;
    color: black;
}
.share-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.share-list {
    overflow: scroll;
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 45%;
    border-radius: 20px;
}

.share-list::-webkit-scrollbar {
    width: 0;
}

.share-list .receiver {
    padding-bottom: 10px;
    margin-bottom: 15px;
    padding-right: 15px;
    border-bottom-color: #f1f1f1;
}

.share-list .receiver:last-child {
    margin-bottom: 0;
    border-bottom: none;
}

.share-list .content {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s;
    border-radius: 20px;
    background-color: rgba(3, 3, 3, 0.368);
}

.share-list .receiver img {
    height: 40px;
    width: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.share-list .receiver .details span {
    font-size: 25px;
}

</style>
<body>
<div class="postbody">
      <div class="container">
        <h1>Posts</h1>

        <div class="card">
          <img src="php/posts/<?php echo $row['post_img']; ?>" class="card-img-top" alt="Post Image">
          <div class="card-body">
            <h5 class="card-title">
              <a href="#" class="post-profile-pic" data-user-id="<?php echo $row['unique_id']; ?>">
                <img src="php/profile_images/<?php echo htmlspecialchars($row['img']); ?>" alt="Profile Picture">
              </a> 
              <?php echo $row['fname'] . ' ' . $row['lname']; ?>
            </h5>
            <p class="card-text"><?php echo $row['post_text']; ?></p>
            <div class="actions">
              <span id="getpostid" hidden><?php echo $post['id']; ?></span>
              <a class="material-icons like-icon" id="like-icon" data-post-id="<?php echo $row['id']; ?>">
                <?php
                $sql2 = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$row['id']} AND unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql2) > 0) {
                  echo "favorite";
                } else {
                  echo "favorite_border";
                }
                $likes_sql = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$row['id']}");
                $likes_array = [];
                while ($likec = mysqli_fetch_assoc($likes_sql)) {
                  $likes_array[] = $likec;
                }
                ?>
              </a>
              <span class="post-like-count" data-post-id="<?php echo $row['id']; ?>"><?php echo count($likes_array); ?></span>
              <a class="material-icons comment-icon" data-post-id="<?php echo $row['id']; ?>">chat_bubble_outline</a>

              <!-- Modal for comments -->
              <div id="commentsModal-<?php echo $row['id']; ?>" class="modal comments-modal">
                <div class="modal-content">
                  <div class="comments-container">
                    <div class="comments-list" data-post-id="<?php echo $row['id']; ?>">
                      <!-- Existing comments will be dynamically added here -->
                    </div>
                    <div class="add-comment">
                      <textarea class="comment-text" placeholder="Write a comment..." data-post-id="<?php echo $post['id']; ?>"></textarea>
                      <button class="comment-cancel" data-post-id="<?php echo $row['id']; ?>">Cancel</button>

                    </div>
                  </div>
                </div>
              </div>
             
            </div>

 
            <p class="card-text"><small class="text-muted"><?php echo $row['created_at']; ?></small></p>
          </div>
          <hr>
          <hr>
        </div>


      </div>
    </div>
<script src="javascript/post.js?v=<?time()?>"></script>
<script src="javascript/comment.js"></script>    
<script src="javascript/share-post.js"></script>    

</body>
</html>