<?php
// Assuming database connection is established and session is started

session_start();
include_once "config.php"; // Ensure database connection

// Sanitize and validate inputs
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$comment_text = isset($_POST['comment_text']) ? mysqli_real_escape_string($conn, $_POST['comment_text']) : '';

if ($post_id <= 0 || empty($comment_text)) {
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'message' => 'Invalid post_id or comment_text'));
    exit;
}

$user_id = $_SESSION['unique_id']; // Assuming user is authenticated via session

// Insert the new comment into database
$sql_insert_comment = "INSERT INTO comments (post_id, user_id, comment_text) 
                       VALUES ($post_id, $user_id, '$comment_text')";

if (mysqli_query($conn, $sql_insert_comment)) {
    echo json_encode(array('success' => true, 'message' => 'Comment submitted successfully'));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('success' => false, 'message' => 'Error submitting comment: ' . mysqli_error($conn)));
}

mysqli_close($conn);
?>
