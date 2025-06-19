const chatBox = document.querySelector(".notification-box");

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/notification.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        addEventListeners();
      }
    }
  };
  xhr.send();
}, 500);

function addEventListeners() {
  const acceptBtns = document.querySelectorAll(".accept");
  const rejectBtns = document.querySelectorAll(".reject");

  acceptBtns.forEach(function (button) {
    button.addEventListener("click", function () {
      console.log("hii");
      const userId = this.getAttribute("data-usr-id");
      fetch("php/req_accept.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "follower_id=" + userId,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
        });
    });
  });

  rejectBtns.forEach(function (button) {
    button.addEventListener("click", function () {
      console.log("hii");
      const userId = this.getAttribute("data-usr-id");
      fetch("php/req_reject.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "follower_id=" + userId,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
        });
    });
  });
}
