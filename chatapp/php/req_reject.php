<?php
session_start();
include_once "config.php";

$follower_id = mysqli_real_escape_string($conn, $_POST['follower_id']);
$unique_id = $_SESSION['unique_id'];

$sql2 = mysqli_query($conn, "UPDATE followers SET is_follow = 1
                            WHERE user_id = $unique_id AND follower_id = $follower_id");
if ($sql2) {
    $sql3 = mysqli_query($conn, "DELETE FROM notification
                                WHERE acc_id = $unique_id AND follower_id = $follower_id");
    if ($sql3) {
        echo "Accepted successfully and notification deleted.";
    } else {
        echo "Error deleting notification: " . mysqli_error($conn);
    }
} else {
    echo "Error updating follower: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
