document.addEventListener("DOMContentLoaded", function () {
  // Select all like icons
  const likeIcons = document.querySelectorAll(".reel-like-icon");

  // Attach event listener to each like icon
  likeIcons.forEach(function (icon) {
    icon.addEventListener("click", function () {
      // Get the post ID from the data attribute of the clicked like icon
      const postId = this.getAttribute("data-post-id");
      const action =
        this.textContent.trim() === "favorite_border"
          ? "php/like_reel.php"
          : "php/unlike_reel.php";

      // Send the POST request to like or unlike the post
      fetch(action, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "post_id=" + postId,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
          // Toggle the like icon state
          const isLiked = this.textContent.trim() === "favorite_border";
          this.textContent = isLiked ? "favorite" : "favorite_border";

          // Get the corresponding like count element
          const likeCountElement = document.querySelector(
            `.reel-like-count[data-post-id="${postId}"]`
          );
          if (likeCountElement) {
            // Increment or decrement the like count
            let likeCount = parseInt(likeCountElement.textContent);
            likeCount = isLiked ? likeCount + 1 : likeCount - 1;
            likeCountElement.textContent = likeCount;
          }
        });
    });
  });
});
