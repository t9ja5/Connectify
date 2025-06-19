<?php
session_start();
include_once "config.php";

if (isset($_POST['unique_id']) && isset($_SESSION['unique_id'])) {
    $user_id = $_POST['unique_id']; 
    $follower_id = $_SESSION['unique_id'];

    // Prepare the SQL statement for inserting into followers
    $sql = "INSERT INTO followers (user_id, follower_id) VALUES (?, ?)";
    $stmt1 = $conn->prepare($sql);
    $stmt1->bind_param("ii", $user_id, $follower_id);

    // Execute the first statement and check for success
    if ($stmt1->execute()) {
        echo "Requested successfully";

        // Prepare the SQL statement for inserting into notifications
        $sql2 = "INSERT INTO notification (acc_id, follower_id) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $user_id, $follower_id);

        // Execute the second statement and check for success
        if ($stmt2->execute()) {
            echo " and notified successfully";
        } else {
            echo " but notification error: " . $stmt2->error;
        }
        $stmt2->close();
    } else {
        echo "Error: " . $stmt1->error;
    }
    $stmt1->close();
} else {
    echo "Error: Missing required parameters.";
}

$conn->close();
?>
