<?php
include_once "config.php";
function getPost(){
    global $con;
    $query = "SELECT posts.id,posts.post_img,posts.post_text,post.created_at,posts.unique_id,users.fname,users.lname,users.img,users.unique_id FROM posts JOIN users ON users.unique_id=posts.unique_id";
    $run =mysqli_query($con,$query);
    return mysqli_fetch_all($run,true);
}
?>