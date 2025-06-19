<?php
session_start();
include_once "config.php";

$post_id = $_POST['post_id']; // ID of the post to like
$unique_id = $_SESSION['unique_id']; // ID of the logged-in user

$sql2 = mysqli_query($conn, "INSERT INTO likes (post_id, unique_id) VALUES ($post_id, $unique_id)");

if ($sql2) {
    echo "like successfully .";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>




