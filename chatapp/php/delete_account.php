<?php
session_start();
include_once "config.php";

header("Content-Type: application/json");

// Ensure the user is logged in
if (!isset($_SESSION['unique_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in first!']);
    exit();
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

// Validate the password
if (isset($data['password'])) {
    $password = $data['password'];
    $user_id = $_SESSION['unique_id'];

    // Fetch the user from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE unique_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Check if confirmation to delete account is present
        if (isset($data['confirm_delete']) && $data['confirm_delete'] === true) {
            // Delete the user account
            $delete_stmt = $conn->prepare("DELETE FROM users WHERE unique_id = ?");
            $delete_stmt->bind_param("i", $user_id);
            if ($delete_stmt->execute()) {
                session_destroy();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete account. Please try again.']);
            }
        } else {
            // Password is correct but deletion not confirmed
            echo json_encode(['success' => true, 'message' => 'Password is correct. Please confirm deletion.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Password not provided.']);
}
?>
