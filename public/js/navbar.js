window.addEventListener("scroll", function() {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 80) {
        navbar.classList.add("scrolled");
        navbar.classList.remove("transparent");
    } else {
        navbar.classList.add("transparent");
        navbar.classList.remove("scrolled");
    }
});

// Set state awal saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
    const navbar = document.getElementById("navbar");
    if (window.scrollY <= 80) {
        navbar.classList.add("transparent");
    }
});
