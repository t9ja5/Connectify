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
$query = "SELECT reels.id, reels.user_id, reels.video_path, reels.caption, users.fname, users.lname, users.img, users.unique_id 
FROM reels
JOIN users ON users.unique_id = reels.user_id
WHERE reels.id = $post_id "; 
$sql = mysqli_query($conn, $query);

if ($sql) {
    if (mysqli_num_rows($sql) > 0) {
        $reel = mysqli_fetch_assoc($sql);
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
    <title>Explore Reels</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<style>
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 24
}
body {
    margin: 0;
     background: url(images/reelsbg.jpg);
    background-size: cover;
        background-attachment: fixed;
    backdrop-filter:blur(2px);
    color: #fff;
    font-family: Arial, sans-serif;
    overflow: hidden; /* Prevent the body from scrolling */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.reel-container {

    position: relative;
    /* width:100%; */
    max-width: 600px;
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */

}

.reel-container::-webkit-scrollbar {
    display: none;  /* Safari and Chrome */
}

.reel {

   position: relative;
    /* width: 100%; */
    height: 98.6vh;
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    border: 4px solid white;
    cursor: pointer;
    border-radius: 30px
}

.reel-video {
    width: 100%;
    height: 100%;
    pointer-events: none; /* Disable default video controls interaction */
}

.user-info {
    position: absolute;
    bottom: 60px;
    left: 2px;
    display: flex;
    background: rgb(255 255 255 / 53%);
    padding: 10px;
    border-radius: 10px;
    width: 95%;
    color: black;
    .username{
        font-size:20px;
    }
}

.user-info img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
    object-fit:cover;
}

.controls {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.controls a {
    background: none;
    border: none;
    /* color: #fff; */
    font-size: 24px;
    margin: 10px 0px;
    cursor: pointer;
    font-size:27px;

}
.like-icon{
    color:red;
}
.reel-comment-icon{
    width:32px;
}
.upload-reel-button {
    position: fixed;
    bottom: 65px;
    right: 65px;
    background: #ffffff;
    color: black;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    color:black;
}

.modal-content {
    background: #000000b0;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    color:white;
    #reelCaption{
        border-radius: 10px;
    border: none;
    outline: none;
    }
    button:hover{
        background:transparent;
        color:white;
        outline:none;
        border:none;
        border-radius:25px;
    }
}

.modal-content input[type="file"],
.modal-content input[type="text"],
.modal-content button {
    margin: 10px 0;
    width: 100%;
    padding: 10px;
}
.logoimg{
    img{
        filter: invert(1);
    position: fixed;
    left: 20px;
    top: 20px;
    }
}
.back-button{
        position: fixed;
    right: 65px;
    top: 65px;
    width: 40px;
    background: transparent;
    color: white;
    border:none;
    font-size:40px;
    cursor:pointer;
}
.reel-comment {
    z-index: 1;
        display: flex;
        align-items: flex-start;
        border-radius: 20px;
        background-color: #09090932;
        padding: 10px;
        margin-bottom: 10px;
    }
    .reel-comment img {
        object-fit: cover;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .reel-comment-content {
        max-width: 80%;
    }
    .reel-comments-modal {
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
    
    .reel-comments-modal .reel-modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 20px;
    }
    .reel-comments-list{
        height: 320px;
        overflow: scroll;
        overflow-x: hidden;
    }
    .reel-add-comment textarea {
        width: 100%;
        margin-top: 10px;
    }
    
    .reel-add-comment button {
        margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: black;
            color: white;
        }
    
    .reel-add-comment button:hover{
        background-color: #0202023f;
        color: black;
    }
    /* Share Modal CSS */
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


</style>
<div class="reel-container">
<body>
            
        <div class="reel">
            <video class="reel-video" muted loop>
                <source src="<?php echo $reel['video_path']; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="user-info">
                
              <a href="others_profile_page.php?user_id='<?php echo $reel['user_id']; ?>'">  <img src="php/profile_images/<?php echo htmlspecialchars($reel['img']); ?>" alt="Profile Pic"></a>
                <div>
                    <div class="username"><?php echo $reel['fname'] . ' ' . $reel['lname']; ?></div>
                    <div class="caption"><?php echo $reel['caption']; ?></div>
                </div>
            </div>

            <div class="controls">
                <div>
                <a class="material-icons like-icon" id="like-icon" data-post-id="<?php echo $reel['id']; ?>">
                <?php
                $sql2 = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$reel['id']} AND unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql2) > 0) {
                  echo "favorite";
                } else {
                  echo "favorite_border";
                }
                $likes_sql = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = {$reel['id']}");
                $likes_array = [];
                while ($likec = mysqli_fetch_assoc($likes_sql)) {
                  $likes_array[] = $likec;
                }
                ?>
              </a>
              <span class="reel-like-count" data-post-id="<?php echo $reel['id']; ?>" ><?php echo count($likes_array); ?></span>
            </div>
            <div>
                <a class= "material-icons reel-comment-icon" data-post-id="<?php echo $reel['id']; ?>">chat_bubble_outline</a>
            </div>

        </div>

        
        <div id="reel-commentsModal-<?php echo $reel['id']; ?>" class="modal reel-comments-modal">
                <div class="reel-modal-content">
                  <div class="comments-container">
                    <div class="reel-comments-list" data-post-id="<?php echo $reel['id']; ?>">
                      <!-- Existing comments will be dynamically added here -->
                    </div>
                    <div class="reel-add-comment">
                      <button class="reel-comment-cancel" data-post-id="<?php echo $reel['id']; ?>">Cancel</button>

                    </div>
                  </div>
                </div>
              </div> 

             
            </div>

            <script src="javascript/explore.js"></script> 
            <script src="javascript/reel-comment.js"></script> 
</body>
</html>