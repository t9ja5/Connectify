<?php
include_once "config.php";

$sql = "SELECT reels.*, users.fname, users.lname, users.img FROM reels JOIN users ON reels.user_id = users.unique_id ORDER BY RAND()";
$result = mysqli_query($conn, $sql);

$reels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reels[] = $row;
}

echo json_encode($reels);
?>
