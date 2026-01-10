// Variables
let profileImg = document.querySelector('.profile-img img');
let nameTag = document.querySelector('.name-tag');
let changeBtn = document.querySelector('.change-color');

// Functions for hovering profile image
function changeProfileImageOver() {
    profileImg.src = 'pgdunk.jpg';
}

function changeProfileImageOut() {
    profileImg.src = 'paulgeorge.jpg';
}

// Functions for toggling color mode
let isDark = true;

function toggleMode() {
    if (isDark) {
        document.body.style.backgroundColor = 'rgb(50, 46, 46)';
        nameTag.style.backgroundColor = 'rgb(50, 46, 46)';
        nameTag.style.color = 'white';
        isDark = false;
    } else {
        document.body.style.backgroundColor = 'white';
        nameTag.style.backgroundColor = 'white';
        nameTag.style.color = 'black';
        isDark = true;
    }
}

changeBtn.addEventListener('click', toggleMode);