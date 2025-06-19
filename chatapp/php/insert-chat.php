<?php
session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

if (!empty($message)) {
    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, file)
            VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '')";
    mysqli_query($conn, $sql);
} elseif (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file = $_FILES['file'];
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $file_path = basename($file["name"]);
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, file) 
                VALUES ({$incoming_id}, {$outgoing_id}, '', '{$file_path}')";
        mysqli_query($conn, $sql);
    } else {
        echo "Error moving uploaded file.";
    }
} else {
    echo "Error: No message or file provided.";
}
?>