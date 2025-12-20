const username = document.querySelector("#username");
const password = document.querySelector("#password");
const submit = document.querySelector("#submit");
const output = document.querySelector("#output");

submit.addEventListener("click", () => {
    const username2 = username.value.trim();
    const password2 = password.value.trim();
    if (!username2) {
        alert("Username is required");
        return;
    }
    if (!password2) {
        alert("Password is required");
        return;
    }
    alert(`Welcome, ${username2}`);
});