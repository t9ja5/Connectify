<?php

include_once "config.php";

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "SELECT comments.comment_text, comments.created_at, users.fname, users.lname, users.img 
            FROM comments 
            JOIN users ON comments.unique_id = users.unique_id 
            WHERE comments.reel_id = $post_id 
            ORDER BY comments.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($comments);
}
?>