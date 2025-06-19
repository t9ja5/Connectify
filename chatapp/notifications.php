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
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    </style>
   </head>
   <style>
    .notification-area{
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url(images/chatbg.jpg);
    }
    .notification-box{
        display:flex;
        flex-direction:column;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        background-color:white;
        color: black;
        height:93vh;
        width:350px;
        padding: 20px;
        border-radius: 25px;
        border:1px solid black
    }
    .notification{
        width: 80%;
        height: 50px;
        background-color:grey;
        display:flex;
        flex-direction:column;
        align-items: center;
        justify-content: space-between;
    }
    .buttons button{
        height:35px;
        width:70px;
        background-color:black;
        color:white;
    }

   </style>
  <body>
    <div class="notification-area">
        <div class="notification-box">
          
        </div>
    </div>
    <script src="javascript/notification.js"></script> 
  </body> 