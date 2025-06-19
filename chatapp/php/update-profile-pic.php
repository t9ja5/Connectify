<?php
session_start();
include_once "config.php"; // Adjust this according to your configuration

// Check if user is logged in
if (!isset($_SESSION['unique_id'])) {
    echo "You need to log in first!";
    exit();
}

// Check if image file was uploaded without errors
if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
    $img_name = $_FILES['profile_img']['name'];
    $img_type = $_FILES['profile_img']['type'];
    $tmp_name = $_FILES['profile_img']['tmp_name'];

    // Validate file extension and type
    $allowed_extensions = ["jpeg", "png", "jpg"];
    $img_explode = explode('.', $img_name);
    $img_ext = strtolower(end($img_explode));

    if (in_array($img_ext, $allowed_extensions) && in_array($img_type, ["image/jpeg", "image/png", "image/jpg"])) {
        // Generate unique file name
        $time = time();
        $new_img_name = $time . "_" . $img_name;
        $upload_path = "profile_images/" . $new_img_name;

        // Move uploaded file to destination
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Update user's profile picture in the database
            $update_query = $conn->prepare("UPDATE users SET img = ? WHERE unique_id = ?");
            $update_query->bind_param("si", $new_img_name, $_SESSION['unique_id']);

            if ($update_query->execute()) {
                header("location: ../profile.php");
            } else {
                echo "Database update failed. Please try again!";
            }
        } else {
            echo "Error uploading image. Please try again!";
        }
    } else {
        echo "Please upload an image file - jpeg, png, jpg";
    }
} else {
    echo "Please upload an image!";
}
?>
