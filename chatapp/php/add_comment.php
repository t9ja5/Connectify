<?php
session_start();
include_once "config.php";

if (isset($_POST['post_id']) && isset($_POST['comment_text'])) {
    $post_id = $_POST['post_id'];
    $unique_id = $_SESSION['unique_id'];
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    $sql = "INSERT INTO comments (post_id, unique_id, comment_text) VALUES ($post_id, $unique_id, '$comment_text')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Comment added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
    }
}
?>
