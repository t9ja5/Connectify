<?php
session_start();
include_once "config.php";

// Ensure session variable is set
if (!isset($_SESSION['unique_id'])) {
    die("Session not started properly.");
}

// Retrieve the posted variables
$userId = $_POST['userId'];
$postId = $_POST['postId'];
$unique_id = $_SESSION['unique_id'];

// Properly format the URL string
$m = "http://localhost/internship/chatapp/single_post.php?post_id=" . $postId;

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userId, $unique_id, $m);

if ($stmt->execute()) {
    echo "Message sent successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
