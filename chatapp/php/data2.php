<?php
while($row = mysqli_fetch_assoc($query)){
    $output .= '<a href="others_profile_page.php?user_id='. $row['unique_id'] .'">
                <div class="content">
                <img src="php/profile_images/'. $row['img'] .'" alt="">
                <div class="details">
                    <span>'. $row['fname']. " " . $row['lname'] .'</span>
                </div>
                </div>
            </a>';
}
?>
