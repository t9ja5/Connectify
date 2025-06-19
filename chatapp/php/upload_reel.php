<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    echo "You must be logged in to upload a reel.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['unique_id'];
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $created_at = date("Y-m-d H:i:s");

    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $video = $_FILES['video'];
        $video_name = $video['name'];
        $video_tmp_name = $video['tmp_name'];
        $video_size = $video['size'];
        $video_error = $video['error'];
        $video_type = $video['type'];

        $video_ext = explode('.', $video_name);
        $video_actual_ext = strtolower(end($video_ext));
        $allowed = array('mp4');

        if (in_array($video_actual_ext, $allowed)) {
            if ($video_error === 0) {
                if ($video_size < 100000000) { // Limit to 100MB
                    $video_name_new = uniqid('', true) . "." . $video_actual_ext;
                    $video_destination = '../uploads/' . $video_name_new;

                    if (move_uploaded_file($video_tmp_name, $video_destination)) {
                        $video_path = 'uploads/' . $video_name_new;

                        $sql = "INSERT INTO reels (user_id, video_path, created_at, caption) VALUES ('$user_id', '$video_path', '$created_at', '$caption')";
                        if (mysqli_query($conn, $sql)) {
                            echo "Reel uploaded successfully!";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        echo "There was an error uploading your file.";
                    }
                } else {
                    echo "Your file is too big.";
                }
            } else {
                echo "There was an error uploading your file.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request method.";
}
?>
