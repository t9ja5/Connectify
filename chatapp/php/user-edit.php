<?php
session_start(); // Start the session to use $_SESSION
include_once "config.php";

// Escape the input data
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$bio = mysqli_real_escape_string($conn, $_POST['bio']);

if (!empty($fname) && !empty($lname) && !empty($email)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows === 0 || $result->fetch_assoc()['unique_id'] == $_SESSION['unique_id']) {
            $status = "Active now";
            $update_query = $conn->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, status = ?, bio = ? WHERE unique_id = ?");
            $update_query->bind_param("sssssi", $fname, $lname, $email, $status, $bio , $_SESSION['unique_id']);

            if ($update_query->execute()) {
                echo "success";
            } else {
                echo "Database update failed. Please try again!";
            }
        } else {
            echo "Email is already in use!";
        }
    } else {
        echo "Invalid email format!";
    }
} else {
    echo "All input fields are required!";
}
?>
