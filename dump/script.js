document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector(".site-nav");
    const updateNav = () =>
        nav?.classList.toggle("is-scrolled", window.scrollY > 30);
    updateNav();
    window.addEventListener("scroll", updateNav, { passive: true });

    document.querySelectorAll(".nav-link").forEach((link) => {
        link.addEventListener("click", () => {
            const menu = document.querySelector("#navMenu");
            if (menu?.classList.contains("show"))
                bootstrap.Collapse.getOrCreateInstance(menu).hide();
        });
    });
});
