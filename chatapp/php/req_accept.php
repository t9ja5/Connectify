<?php
session_start();
include_once "config.php";

$follower_id = $_POST['follower_id']; 
$unique_id = $_SESSION['unique_id']; 
$sql2 = mysqli_query($conn, "UPDATE followers SET  is_follow =1
                            WHERE user_id=$unique_id AND follower_id=$follower_id");
$sql3 = mysqli_query($conn, "DELETE FROM notification
                            WHERE acc_id=$unique_id AND follower_id=$follower_id");
if ($sql2) {
    echo "accepted successfully .";
} else {
    echo "Error: " . mysqli_error($conn);
}
if($sql3){
    echo "Success";
}

mysqli_close($conn);
?>




