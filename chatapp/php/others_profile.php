<?php
include_once "php/config.php";

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Fetch user details from the database
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$user_id'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);

        // Fetch posts of the user
        $posts_sql = mysqli_query($conn, "SELECT * FROM posts WHERE unique_id = '$user_id'");
        $posts = [];
        while ($post = mysqli_fetch_assoc($posts_sql)) {
            $posts[] = $post;
        }
    } else {
        // Handle user not found
        echo "User not found.";
        exit;
    }
} else {
    // Redirect to homepage if user_id is not provided
    header("Location: homepage.php");
    exit();
}
?>