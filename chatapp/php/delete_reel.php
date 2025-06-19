<?php
session_start();
include_once "config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $reel_id = $data['reel_id'];
    $user_id = $_SESSION['unique_id'];

    // Check if the reel belongs to the logged-in user
    $reel_check_sql = mysqli_query($conn, "SELECT * FROM reels WHERE id = {$reel_id} AND user_id = {$user_id}");
    if (mysqli_num_rows($reel_check_sql) > 0) {
        $delete_reel_sql = mysqli_query($conn, "DELETE FROM reels WHERE id = {$reel_id} AND user_id = {$user_id}");
        if ($delete_reel_sql) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting reel.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unauthorized action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
