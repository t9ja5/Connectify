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
     <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
   
    <title>Settings
    </title>
</head>
<style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    </style>
<style>

   body {
     padding: 0;
     margin: 0;
     box-sizing: border-box;
    font-family: poppins;
     background: url(images/bg4.jpg);
    background-size: cover;
        background-attachment: fixed;
 }
   
  /* sidebar css */
   
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 200px;
    background-color: rgb(0 0 0 / 47%);
    -webkit-backdrop-filter: blur(17px);
    backdrop-filter: blur(5px);
    border-right: 1px solid rgba(255, 255, 255, 0.192);
    overflow-y: auto;
    overflow-x: hidden;
    color: white;
}

   .logo img {
       margin-top: 20px;
       height: 50px;
       width: 170px;
       padding: 5px 10px;
       filter:invert();
   }

ul {
    padding: 0;
    margin: 0;
    list-style-type: none;
}

.sidebar .links {
    list-style-type: none;
    margin-top: 20px;
    width: 75%;
    padding: 20px;
    height: 71%;;
}

.links li {
    display: flex;
    align-items: center;
}

.links li a {
    color: white;
    padding: 10px;
    font-weight: 500;
    white-space: nowrap;
    text-decoration: none;
    display: block;
    width: 50%;
    box-sizing: border-box;
}

.links li:hover {
    background: #ccc;
    border-radius: 4px;
    cursor: pointer;
}

.links li span {
    padding: 12px 10px;
}

.links hr {
    border: 1px solid white;
}

/* setting area css */

.settingArea{
  border: none;
    border-radius: 20px;
    margin: 20px;
    color: white;
    font-family:poppins;
    position: absolute;
    left: 200px;
    width: 78%;
    border: none;
    box-shadow: 0px 0px 8px 13px rgba(0, 0, 0, 0.1);
    background-color: #000000a1;
    padding: 20px;
    p{
      padding-bottom:10px;
    }
}

#deleteAccountBtn{
  border: none;
    border-radius: 20px;
    padding: 15px;
    font-family: 'Poppins';
    border: none;
    border-radius: 20px;
    padding: 15px;
    font-family: 'Poppins';
}
#deleteAccountBtn:hover{
  background-color:#ffffff59;
  color:white;
}



/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
 
/* post modal css */
.modal {
     display: none;
     position: fixed;
     z-index: 1000;
     left: 0;
     top: 0;
     width: 100%;
     height: 100%;
     overflow: auto;
     background-color: rgba(0, 0, 0, 0.5);
     animation: fadeIn 0.3s;
 }

 @keyframes fadeIn {
     from {
         opacity: 0;
     }

     to {
         opacity: 1;
     }
 }

 .modal-content {
     background-color: #fefefe81;
     margin: 15% auto;
     padding: 20px;
     border: 1px solid #888;
     width: 80%;
     max-width: 500px;
     animation: slideDown 0.3s;
 }

 @keyframes slideDown {
     from {
         transform: translateY(-100%);
     }

     to {
         transform: translateY(0);
     }
 }

 .close {
     color: #020202;
     float: right;
     font-size: 28px;
     font-weight: bold;
 }

 .close:hover,
 .close:focus {
     color: black;
     text-decoration: none;
     cursor: pointer;
 }

 textarea {
     width: 100%;
     height: 100px;
     margin: 10px 0;
 }

 button[type="submit"] {
     background-color: #4CAF50;
     color: white;
     padding: 10px 20px;
     border: none;
     cursor: pointer;
 }

 button[type="submit"]:hover {
     background-color: #45a049;
 }

 #post_img {
     max-width: 100%;
     max-height: 200px;
     margin-top: 10px;
     display: block;
 }

</style>
<body>
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
          <a href="explore.php">Explore</a>
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
          <a href="#">Settings</a>
        </li>
        <li>
          <span class="material-icons">logout</span>
           <a href="php/logout.php?logout_id=<?php echo $_SESSION['unique_id']; ?>" class="btn">Logout</a>
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
    <div class="settingArea">
       <div class="delAcc">
        <p>Want to delete the account?</p>
        <div class="delAccBtn">
           <!-- Delete Account Button -->
            <button id="deleteAccountBtn">Delete Account</button>
           
            <!-- Delete Account Modal -->
             <div id="deleteAccountModal" class="modal">
                <div class="modal-content">
                   <span id="close">&times;</span>
                   <h2>Confirm Account Deletion</h2>
                   <form id="deleteAccountForm">
                       <label for="password">Enter your password:</label>
                       <input type="password" id="password" name="password" required>
                       <button type="submit">Confirm</button>
                   </form>
               </div>
          </div>
        </div>
       </div>
    </div>
    <script src="javascript/settings.js"></script>
    <script src="javascript/post.js"></script>
</body>
</html>