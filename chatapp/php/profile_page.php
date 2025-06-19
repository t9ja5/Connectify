<?php
session_start();
include_once "php/config.php";

if (!isset($_SESSION['unique_id'])) {
    header("Location: homepage.php");
    exit();
}

function getUserPosts($user_id, $conn) {
    $query = "SELECT posts.id,posts.post_img, posts.post_text, posts.created_at, users.fname, users.lname, users.img 
              FROM posts 
              JOIN users ON users.unique_id = posts.unique_id 
              WHERE posts.unique_id = ? 
              ORDER BY posts.created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$user_id = $_SESSION['unique_id'];
$posts = getUserPosts($user_id, $conn);

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
if (mysqli_num_rows($sql) > 0) {
    $user = mysqli_fetch_assoc($sql);
}
?>
