<?php
session_start();
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = validatePostImage($_FILES['post_img']);
    if ($response['status']) {
        if (createPost($_POST, $_FILES['post_img'])) {
            header("Location: ../homepage.php?new_post_added");
            exit;
        } else {
            echo "Something went wrong while creating the post.";
        }
    } else {
        $_SESSION['error'] = $response['msg'];
        header("Location: ../homepage.php");
        exit;
    }
}

function validatePostImage($image_data) {
    $response = array();
    $response['status'] = true;

    if (!$image_data['name']) {
        $response['msg'] = "No image selected.";
        $response['status'] = false;
        return $response;
    }

    $image = basename($image_data['name']);
    $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $size = $image_data['size'] / 1024; // Size in KB

    if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
        $response['msg'] = "Only JPG, JPEG, and PNG images are allowed.";
        $response['status'] = false;
    }

    if ($size > 1000) {
        $response['msg'] = "Upload image less than 1 MB.";
        $response['status'] = false;
    }

    return $response;
}

function createPost($postData, $image) {
    global $conn;
    $user_id = $_SESSION['unique_id'];
    $post_text = mysqli_real_escape_string($conn, $postData['post_text']);
    $image_name = time() . '_' . basename($image['name']);
    $image_dir = "./posts"; 

  
    if (!is_dir($image_dir)) {
        mkdir($image_dir, 0777, true);
    }

    $image_path = "$image_dir/$image_name";

    if (move_uploaded_file($image['tmp_name'], $image_path)) {
        $query = "INSERT INTO posts (unique_id, post_text, post_img) VALUES ('$user_id', '$post_text', '$image_name')";
        return mysqli_query($conn, $query);
    } else {
        return false;
    }
}

function getPost() {
    global $conn;
    $query = "SELECT posts.id, posts.post_img, posts.post_text, posts.created_at, posts.unique_id, users.fname, users.lname, users.img, users.unique_id FROM posts JOIN users ON users.unique_id=posts.unique_id";
    $run = mysqli_query($conn, $query);
    return mysqli_fetch_all($run, MYSQLI_ASSOC);
}
?>
