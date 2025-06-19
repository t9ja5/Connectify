const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector("button.send"),
  fileInput = form.querySelector("#file-input"),
  fileUploadBtn = form.querySelector("#file-upload-button"),
  chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
  e.preventDefault();
};

inputField.focus();
inputField.onkeyup = () => {
  if (inputField.value.trim() !== "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};

sendBtn.onclick = () => {
  if (fileInput.files.length > 0) {
    sendFile(fileInput.files[0]);
  } else if (inputField.value.trim() !== "") {
    sendChatMessage();
  }
};

fileUploadBtn.onclick = () => {
  fileInput.click();
};

fileInput.onchange = () => {
  const file = fileInput.files[0];
  if (file) {
    sendFile(file);
  }
};

chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

setInterval(() => {
  fetchChat();
}, 500);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}

function sendChatMessage() {
  let message = inputField.value.trim();
  if (message !== "") {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          inputField.value = "";
          scrollToBottom();
          fetchChat();
        } else {
          console.error("Error sending message.");
        }
      }
    };
    let formData = new FormData();
    formData.append("incoming_id", incoming_id);
    formData.append("message", message);
    xhr.send(formData);
  }
}

function sendFile(file) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("File uploaded successfully");
        fileInput.value = ""; // Reset file input
        scrollToBottom();
        fetchChat();
      } else {
        console.error("Error uploading file");
      }
    }
  };
  let formData = new FormData();
  formData.append("incoming_id", incoming_id);
  formData.append("file", file);
  xhr.send(formData);
}

function fetchChat() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/get-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        if (!chatBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + incoming_id);
}
