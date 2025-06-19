document.addEventListener("DOMContentLoaded", () => {
  setupReelScrolling();
  setupUploadModal();
});
 
function setupReelScrolling() {
  const reels = document.querySelectorAll(".reel-video");
  const options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.5,
  };

  let currentVideo = null;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        if (currentVideo && currentVideo !== entry.target) {
          currentVideo.pause();
          currentVideo.currentTime = 0; // Reset the video
        }
        currentVideo = entry.target;
        entry.target.play();
        entry.target.muted = false; // Unmute the video when it is in view
      } else {
        entry.target.pause();
        entry.target.muted = true; // Mute the video when it is out of view
        entry.target.currentTime = 0; // Reset the video
      }
    });
  }, options);

  reels.forEach((reel) => {
    observer.observe(reel);
    reel.closest(".reel").addEventListener("click", togglePlayPause);
  });
}

function setupUploadModal() {
  const uploadReelButton = document.getElementById("uploadReelButton");
  const uploadModal = document.getElementById("uploadModal");

  uploadReelButton.onclick = () => {
    uploadModal.style.display = "flex";
  };

  window.onclick = (event) => {
    if (event.target === uploadModal) {
      uploadModal.style.display = "none";
    }
  };
}

function togglePlayPause(event) {
  const reel = event.currentTarget;
  const video = reel.querySelector(".reel-video");
  if (video.paused) {
    video.play();
    video.muted = false; // Unmute the video when playing
  } else {
    video.pause();
    video.muted = true; // Mute the video when paused
  }
}

async function uploadReel() {
  const video = document.getElementById("reelVideoFile").files[0];
  const caption = document.getElementById("reelCaption").value;

  const formData = new FormData();
  formData.append("video", video);
  formData.append("caption", caption);

  const response = await fetch("php/upload_reel.php", {
    method: "POST",
    body: formData,
  });

  const result = await response.text();
  alert(result);
  document.getElementById("uploadModal").style.display = "none";
  location.reload();
}

function likeReel(button) {
  const likeCount = button.querySelector(".like-count");
  likeCount.textContent = parseInt(likeCount.textContent) + 1;
}

function dislikeReel() {
  // Handle dislike functionality
}

function shareReel() {
  // Handle share functionality
}
