document.addEventListener("DOMContentLoaded", function () {
    const shareIcons = document.querySelectorAll(".share-icon");
    var postno =0;
    shareIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
  
            const postId = icon.getAttribute("data-post-id");
            postno=postId;
            const modal = document.getElementById(`ShareModal-${postId}`);
            const shareList = modal.querySelector(".share-list");
  
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "php/sharelist.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.responseText;
                        shareList.innerHTML = data;
                    }
                }
            };
            xhr.onerror = () => {
                console.error("An error occurred while making the request");
            };
            xhr.send();
  
            modal.style.display = "flex";
            modal.style.flexDirection = "column";
            modal.style.alignItems = "center";     
            
        });
    });
  
    document.addEventListener("click", function(event) {
        let target = event.target;
    
        // Traverse up the DOM tree to check if the clicked element or its ancestor has the .receiver class
        while (target && target !== document) {
            if (target.classList.contains("receiver")) {
                const contentElement = target.querySelector(".content");
                if (contentElement) {
                    const userId = contentElement.getAttribute("data-post-id");
                    console.log("Clicked receiver with post ID:", userId);
                    console.log(postno);
    
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "php/sendreelurl.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {
                            console.log(xhr.responseText);
                        } else {
                            console.error("Error occurred during request");
                        }
                    };
    
                    const params = `userId=${userId}&postId=${postno}`;
                    xhr.send(params);
                } else {
                    console.error("Content element not found");
                }
                return; // Exit the function once the .receiver element is found and processed
            }
            target = target.parentNode; // Move up the DOM tree
        }
    });
    
    document.querySelectorAll(".share-cancel").forEach((button) => {
        button.addEventListener("click", function () {
          const postId = button.getAttribute("data-post-id");
          const modal = document.getElementById(`ShareModal-${postId}`);
          modal.style.display = "none";
        });
      });
  });
  