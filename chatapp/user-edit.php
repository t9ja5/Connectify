<?php 
  session_start();
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
    </style>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100%;
            box-sizing: border-box;
            background: url(images/bg4.jpg);
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        .area {
             padding: 20px;
             box-sizing: border-box;
             overflow-y: auto;
             overflow-x: hidden;
             display: flex;
             justify-content: center;
             align-items: center;
             height:100vh;
        }

         .formArea{
            border-radius:15px;
            color: white;
            padding: 10px 30px;
            backdrop-filter: blur(3px);
            background-color: #00000087;
            /* box-shadow: 0px 0px 18px 9px rgb(0 0 0 / 54%); */
        }
        .logo img {
            margin-top: 20px;
            height: 50px;
            width: 170px;
            padding: 5px 10px;
        }

        .title {    
            font-weight: 500;
            font-size: 30px;
            margin-bottom: 10px;
            text-align:center;
            margin-top: 0px;
            padding-top: 0px;
        }

        form .name-details {
            display: flex;
        }

        .name-details label {
            width: 100%;
        }

        .name-details input {
            width: 100%;
        }

        .name-details .field:first-child {
            margin-right: 10px;
            width: 40%;
        }

        .name-details .field:last-child {
            width: 40%;
            margin-left: 10px;
        }

        form .field {
            display: flex;
            margin-bottom: 23px;
            flex-direction: column;
            position: relative;

        }

        form .field label {
            margin-bottom: 2px;
        }

        form .input input {
            height: 40px;
            width: 90%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form form .field input {
            outline: none;
        }

        form .button {
            width: 70%;
            display: flex;
            flex-direction: row;
            gap: 30px;
        }

        form .button input {
            height: 45px;
            width: 20%;
            color: #fff;
            font-size: 17px;
            background: #333;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #333;
            margin-top: 13px;
        }

        form .button button {
            height: 45px;
            width: 20%;
            color: #333;
            font-size: 17px;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 13px;
            border: 1px solid #333;
        }

        #update_profile_pic {
            img{
                border-radius: 61%;
                width: 300px;
                object-fit: cover;
                height: 300px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main">
    <?php 
            include_once "php/config.php";
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
       

        <div class="area">
             <div class="formArea">
            <div class="title">
                <div><span class="material-icons">edit</span>Edit Profile </div>
            </div>
            <form action="#" class="form" id="profileForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>


                <div class="name-details">
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" value=<?php echo $row['fname'] ?> required>
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" value="<?php echo $row['lname'] ?>" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" value="<?php echo $row['email'] ?>" required>
                </div>

                <div class="field input">
                    <label>Bio</label>
                    <input type="text" name="bio" placeholder="Enter new bio" value="<?php echo $row['bio'] ?>" required>
                </div>
                <!-- <div class="field input">
                  
                       <label>Profile Picture</label>
                    <div id="update_profile_pic" class="modal">
                        <img src="" style="display:none" id="profile_img">
                        <input type="file" name="image" id="select_profile_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required />
                    </div>
                </div> -->
                <div class="field button">
                    <button type="button" class="cancel">Cancel</button>
                    <input type="submit" name="submit" value="Save">
                </div>
            </form>
        </div>
        </div>
    </div>
    <script src="javascript/user-edit.js"></script>

</body>

</html>