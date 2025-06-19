<?php
    session_start();
    include_once "config.php";

    $sql = "SELECT u.fname, u.lname, u.img ,u.unique_id
        FROM users u 
        JOIN followers f ON f.follower_id = u.unique_id 
        WHERE f.user_id = {$_SESSION['unique_id']} 
        ORDER BY u.user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to share";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data3.php";
    }
    echo $output;
?>