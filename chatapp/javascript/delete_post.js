document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-post").forEach((deleteIcon) => {
    deleteIcon.addEventListener("click", function () {
      const postId = this.getAttribute("data-post-id");
      const userConfirmed = confirm(
        "Are you sure you want to delete this post?"
      );
      if (userConfirmed) {
        deletePost(postId);
      }
    });
  });
});

function deletePost(postId) {
  fetch(`php/delete_post.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ post_id: postId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("Post deleted successfully.");
        document.querySelector(`.post[data-post-id='${postId}']`).remove();
      } else {
        console.error("Error deleting post: ", data.message);
      }
    })
    .catch((error) => {
      console.error("Error: ", error);
    });
}
