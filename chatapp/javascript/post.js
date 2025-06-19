document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("addpost");
    const btn = document.getElementById("openModalBtn");
    const span = document.getElementsByClassName("close")[0];
    const fileInput = document.getElementById('select_post_image');
    const postImg = document.getElementById('post_img');

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
        postImg.style.display = "none";
        postImg.src = "";
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
            postImg.style.display = "none";
            postImg.src = "";
        }
    }

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                postImg.src = e.target.result;
                postImg.style.display = "block";
            }
            reader.readAsDataURL(file);
        } else {
            postImg.style.display = "none";
            postImg.src = "";
        }
    });
});
