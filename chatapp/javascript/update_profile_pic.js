document.addEventListener("DOMContentLoaded", () => {
  const updateProfilePicBtn = document.getElementById("changeProfilePicBtn");
  const modal = document.getElementById("updateProfilePic");
  const closeModal = document.getElementById("close");
  const fileInput = document.getElementById("select_profile_image");
  const profileImg = document.getElementById("profile_img");
  const postForm = document.getElementById("postForm");
  const errorText = document.createElement("p");
  const profilePic = document.querySelector(".profilePic");

  // Show modal when clicking "Change Profile Pic"
  updateProfilePicBtn.addEventListener("click", () => {
    modal.style.display = "block";
  });

  // Hide modal when clicking the close button
  closeModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Hide modal when clicking outside the modal content
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // Profile image preview
  fileInput.addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        profileImg.src = e.target.result;
        profileImg.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      profileImg.style.display = "none";
      profileImg.src = "";
    }
  });

  // Handle form submission
  postForm.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission

    let formData = new FormData(postForm);

    try {
      let response = await fetch("php/update-profile-pic.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        let data = await response.text();
        if (data.trim() === "success") {
          // Update the profile picture without reloading the page
          profilePic.src = profileImg.src;
          modal.style.display = "none";
        } else {
          throw new Error(data);
        }
      } else {
        throw new Error("Network response was not ok.");
      }
    } catch (error) {
      console.error("Error:", error.message);
      errorText.style.display = "block";
      errorText.textContent = error.message;
      postForm.appendChild(errorText);
    }
  });
});
