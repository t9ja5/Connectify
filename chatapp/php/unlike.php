<?php
session_start();
include_once "config.php";

$post_id = $_POST['post_id']; // ID of the post to unlike
$unique_id = $_SESSION['unique_id']; // ID of the logged-in user

$sql2 = mysqli_query($conn, "DELETE FROM likes WHERE post_id = $post_id AND unique_id = $unique_id");

if ($sql2) {
    echo "Unliked successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
