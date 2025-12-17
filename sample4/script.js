const btn = document.querySelector("#animatedBtn");

btn.addEventListener("click", () => {
    // ripple
    btn.classList.add("ripple");
    setTimeout(() => btn.classList.remove("ripple"), 600);

    // loading animation
    btn.classList.add("loading");

    setTimeout(() => {
        btn.classList.remove("loading");
        alert("Submitted successfully!");
    }, 2000);
});
