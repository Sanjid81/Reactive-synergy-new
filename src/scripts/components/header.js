const toggle = document.querySelector(".nav-toggle");
const nav = document.querySelector(".header-nav");
const mobile = window.matchMedia("(max-width: 1200px)");

if (toggle && nav) {
    toggle.addEventListener("click", () => {
        const open = nav.classList.toggle("is-open");
        toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
}

if (nav) {
    nav.querySelectorAll(".menu-item-has-children > a").forEach((link) => {
        link.setAttribute("aria-expanded", "false");
        link.addEventListener("click", (event) => {
            if (!mobile.matches) {
                return;
            }

            event.preventDefault();
            const item = link.parentElement;
            const open = item.classList.toggle("is-open");
            link.setAttribute("aria-expanded", open ? "true" : "false");

            nav.querySelectorAll(".menu-item-has-children.is-open").forEach((other) => {
                if (other === item) {
                    return;
                }
                other.classList.remove("is-open");
                other.querySelector(":scope > a")?.setAttribute("aria-expanded", "false");
            });
        });
    });
}
