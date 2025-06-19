document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("signupForm");
  const errorText = document.querySelector(".error-text");

  form.onsubmit = async (e) => {
    e.preventDefault();
    let formData = new FormData(form);

    try {
      let response = await fetch("php/send_otp.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        window.location.href = "verify_otp.php";
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
 