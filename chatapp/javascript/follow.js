const hiddenspan = document.getElementById('getuniqueid').textContent;

document.getElementById('follow-btn').addEventListener('click', function() {
    var uniqueId = hiddenspan;
    var btnText = this.textContent.trim();
    var action;
    
    if (btnText === 'Follow') {
        action = 'php/follow.php';
    } else {
        action = 'php/unfollow.php';
    }

    fetch(action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'unique_id=' + encodeURIComponent(uniqueId)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        if (btnText === 'Follow') {
            this.textContent = 'Requested';
        } else if (btnText === 'Requested') {
            this.textContent = 'Follow';
        } else {
            this.textContent = 'Follow';
        }
    })
    .catch(error => console.error('Error:', error));
});
