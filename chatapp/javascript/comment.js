document.addEventListener("DOMContentLoaded", function () {
  const commentIcons = document.querySelectorAll(".comment-icon");
  const commentCounts = document.querySelectorAll(".comment-count");

  commentIcons.forEach((icon) => {
    icon.addEventListener("click", function () {
      const postId = icon.getAttribute("data-post-id");
      const modal = document.getElementById(`commentsModal-${postId}`);
      const commentList = modal.querySelector(".comments-list");

      // Fetch existing comments
      fetch(`php/get_comments.php?post_id=${postId}`)
        .then((response) => response.json())
        .then((comments) => {
          commentList.innerHTML = "";
          comments.forEach((comment) => {
            const commentElement = document.createElement("div");
            commentElement.classList.add("comment");
            commentElement.innerHTML = `
              <img src="php/profile_images/${comment.img}" alt="Profile Picture" class="comment-profile-pic" height="40px" width="40px">
              <div class="comment-content">
                <strong>${comment.fname} ${comment.lname}</strong>
                <p>${comment.comment_text}</p>
                <small class="text-muted">${comment.created_at}</small>
              </div>
            `;
            commentList.appendChild(commentElement);
          });
        });

      modal.style.display = "block";
    });
  });

  document.querySelectorAll(".submit-comment").forEach((button) => {
    button.addEventListener("click", function () {
      const postId = button.getAttribute("data-post-id");
      const commentText = document.querySelector(
        `.comment-text[data-post-id="${postId}"]`
      ).value;

      fetch("php/add_comment.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `post_id=${postId}&comment_text=${commentText}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            const commentList = document.querySelector(
              `.comments-list[data-post-id="${postId}"]`
            );
            const newComment = document.createElement("div");
            newComment.classList.add("comment");
            newComment.innerHTML = `
              <img src="php/profile_images/${data.img}" alt="Profile Picture" class="comment-profile-pic">
              <div class="comment-content">
                <strong>${data.fname} ${data.lname}</strong>
                <p>${commentText}</p>
                <small class="text-muted">Just now</small>
              </div>
            `;
            commentList.appendChild(newComment);
            document.querySelector(
              `.comment-text[data-post-id="${postId}"]`
            ).value = "";
          }
        });
    });
  });

  // Close the modal when the cancel button is clicked
  document.querySelectorAll(".comment-cancel").forEach((button) => {
    button.addEventListener("click", function () {
      const postId = button.getAttribute("data-post-id");
      const modal = document.getElementById(`commentsModal-${postId}`);
      modal.style.display = "none";
    });
  });
});
