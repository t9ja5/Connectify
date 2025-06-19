<?php
session_start();
include_once "config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $post_id = $data['post_id'];
    $user_id = $_SESSION['unique_id'];

    // Check if the post belongs to the logged-in user
    $post_check_sql = mysqli_query($conn, "SELECT * FROM posts WHERE id = {$post_id} AND unique_id = {$user_id}");
    if (mysqli_num_rows($post_check_sql) > 0) {
        $delete_post_sql = mysqli_query($conn, "DELETE FROM posts WHERE id = {$post_id} AND unique_id = {$user_id}");
        if ($delete_post_sql) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting post.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unauthorized action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
