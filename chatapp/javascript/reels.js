document.addEventListener("DOMContentLoaded", function () {
  const postsTab = document.getElementById("postsTab");
  const reelsTab = document.getElementById("reelsTab");
  const postsSection = document.getElementById("postsSection");
  const reelsSection = document.getElementById("reelsSection");

  postsTab.addEventListener("click", function () {
    postsTab.classList.add("active");
    reelsTab.classList.remove("active");
    postsSection.classList.add("active");
    reelsSection.classList.remove("active");
  });

  reelsTab.addEventListener("click", function () {
    postsTab.classList.remove("active");
    reelsTab.classList.add("active");
    postsSection.classList.remove("active");
    reelsSection.classList.add("active");
  });

  document.querySelectorAll(".reel-video").forEach((video) => {
    video.addEventListener("click", function () {
      if (video.requestFullscreen) {
        video.requestFullscreen();
      } else if (video.mozRequestFullScreen) {
        video.mozRequestFullScreen();
      } else if (video.webkitRequestFullscreen) {
        video.webkitRequestFullscreen();
      } else if (video.msRequestFullscreen) {
        video.msRequestFullscreen();
      }
      video.play();
    });
  });
});
