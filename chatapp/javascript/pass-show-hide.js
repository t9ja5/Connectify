const pswrdField = document.querySelector(".form input[type='password']"),
  pswrdField2 = document.getElementById("password"),
  toggleIcon = document.querySelector(".form .field i");
toggleIcon2 = document.getElementById("eye");

toggleIcon.onclick = () => {
  if (pswrdField.type === "password") {
    pswrdField.type = "text";
    toggleIcon.classList.add("active");
  } else {
    pswrdField.type = "password";
    toggleIcon.classList.remove("active");
  }
};
toggleIcon2.onclick = () => {
  if (pswrdField2.type === "password") {
    pswrdField2.type = "text";
    toggleIcon2.classList.add("active");
  } else {
    pswrdField2.type = "password";
    toggleIcon2.classList.remove("active");
  }
};
