let toggle_button = document.getElementById("sidebar-toggle");
let screen_size = window.innerWidth;
let sidebar = document.getElementById("sidebar");
let close_button = document.getElementById("sidebar-close");
if (screen_size < 992) {
    sidebar.classList.add("hide");
    toggle_button.addEventListener("click", function () {
        let sidebar = document.getElementById("sidebar");
        if (sidebar.classList.contains("hide")) {
            sidebar.classList.remove("hide");
        } else {
            sidebar.classList.add("hide");
        }
    });
    close_button.addEventListener("click", function () {
        let sidebar = document.getElementById("sidebar");
        if (sidebar.classList.contains("hide")) {
            sidebar.classList.remove("hide");
        } else {
            sidebar.classList.add("hide");
        }
    });
}
