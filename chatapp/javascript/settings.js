document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("deleteAccountModal");
  const btn = document.getElementById("deleteAccountBtn");
  const span = document.getElementsByClassName("close")[0];
  const form = document.getElementById("deleteAccountForm");

  // Open the modal when the button is clicked
  btn.onclick = function () {
    modal.style.display = "block";
  };

  // Close the modal when the user clicks the close button
  span.onclick = function () {
    modal.style.display = "none";
  };

  // Close the modal when the user clicks anywhere outside of the modal
  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };

  // Handle form submission
  form.onsubmit = function (event) {
    event.preventDefault();
    const password = document.getElementById("password").value;

    // Send a POST request to the PHP script to verify password
    fetch("php/delete_account.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ password: password }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Confirm with the user before sending the request to delete the account
          if (confirm("Are you sure you want to delete your account?")) {
            // Send a request to delete the account
            fetch("php/delete_account.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({
                password: password,
                confirm_delete: true,
              }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  alert("Account deleted.");
                  window.location.href = "index.php"; // Redirect to logout page
                } else {
                  alert(data.message);
                }
              })
              .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
              });
          }
        } else {
          alert("Incorrect password. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
      });
  };
});
