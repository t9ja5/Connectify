document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form"),
    saveBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-text"),
    cancelBtn = document.querySelector(".button button");

  // Handle cancel button click
  cancelBtn.onclick = () => {
    location.href = "profile.php";
  };

  // Handle form submission
  form.onsubmit = async (e) => {
    e.preventDefault();
    let formData = new FormData(form);

    try {
      let response = await fetch("php/user-edit.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        let data = await response.text();
        if (data === "success") {
          location.href = "profile.php";
        } else {
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      } else {
        throw new Error("Network response was not ok.");
      }
    } catch (error) {
      console.error("Error:", error);
      errorText.style.display = "block";
      errorText.textContent = "Something went wrong. Please try again!";
    }
  };
});
