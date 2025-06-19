document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-reel").forEach((deleteIcon) => {
    deleteIcon.addEventListener("click", function () {
      const reelId = this.getAttribute("data-reel-id");
      const userConfirmed = confirm(
        "Are you sure you want to delete this reel?"
      );
      if (userConfirmed) {
        deleteReel(reelId);
      }
    });
  });
});

function deleteReel(reelId) {
  fetch(`php/delete_reel.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ reel_id: reelId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("Reel deleted successfully.");
        document.querySelector(`.reel[data-reel-id='${reelId}']`).remove();
      } else {
        console.error("Error deleting reel: ", data.message);
      }
    })
    .catch((error) => {
      console.error("Error: ", error);
    });
}
