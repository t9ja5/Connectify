<?php 
    session_start();
    include_once "config.php";
    
    $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if(!empty($newpassword) && !empty($password)){
        if($password == $newpassword){
            // Use password_hash instead of md5
            $user_pass = md5($newpassword);
            $status = "Active now";
            
            // Use prepared statements
            $stmt = $conn->prepare("UPDATE users SET password = ?, status = ? WHERE email = ?");
            $stmt->bind_param("sss", $user_pass, $status, $_SESSION['email']);
            
            if($stmt->execute()){
                echo "success";
                $stmt->close();
                
                $stmt2 = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt2->bind_param("s", $_SESSION['email']);
                $stmt2->execute();
                $result = $stmt2->get_result();
                $row = $result->fetch_assoc();
                
                $_SESSION['unique_id'] = $row['unique_id'];
                $stmt2->close();
            } else {
                echo "Something went wrong";
            }
        } else {
            echo "Both input fields must be the same";
        }
    } else {
        echo "All input fields are required!";
    }
?>
