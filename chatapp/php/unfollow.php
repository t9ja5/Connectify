<?php
session_start();
include_once "config.php";

$user_id = $_POST['unique_id']; 
$follower_id = $_SESSION['unique_id'];

// Using prepared statements to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM followers WHERE user_id = ? AND follower_id = ?");
$stmt->bind_param("ii", $user_id, $follower_id);

if ($stmt->execute()) {
    echo "Unfollowed successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
