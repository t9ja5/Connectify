<?php
session_start();
include_once "config.php";

$acc_id = $_SESSION['unique_id'];
$output = "";

$sql ="SELECT u.fname, u.lname, u.unique_id , n.acc_id ,n.follower_id 
        FROM users u 
        JOIN notification n ON n.follower_id = u.unique_id 
        WHERE n.acc_id = {$_SESSION['unique_id']} 
        ORDER BY n.id DESC";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
       $output .='<div class="notification">
                    <div class="detail">
                        <span>'. $row['fname']. " " . $row['lname'] .' Wants to follow you</span>
                    </div>
                    <div class="buttons">
                        <button class="accept" id="accept" data-usr-id="'.$row['follower_id'].'">Accept</button>
                        <button class="reject" id="reject" data-usr-id="'.$row['follower_id'].'">Reject</button>
                    </div>
                  </div>';
    }
}
echo $output;
?>
