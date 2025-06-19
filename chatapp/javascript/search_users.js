const usersList = document.querySelector("#userList");
const searchBar = document.querySelector("#search");

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  if (searchTerm != "") {
    searchBar.classList.add("active");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search_users.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          usersList.innerHTML = data;
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
  } else {
    searchBar.classList.remove("active");
    usersList.innerHTML = ""; // Clear the user list when search input is empty
  }
};
