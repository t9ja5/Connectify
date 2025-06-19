<?php
    while ($row = mysqli_fetch_assoc($query)) {
        $output .= '<a class="receiver">
                    <div class="content" data-post-id="' . $row['unique_id'] . '">
                    <img src="php/profile_images/' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>' . $row['fname'] . ' ' . $row['lname'] . '</span>
                    </div>
                    </div>
                </a>';
    }
?>
