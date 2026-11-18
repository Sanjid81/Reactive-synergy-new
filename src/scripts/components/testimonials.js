import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import "swiper/css";

document.querySelectorAll("[data-testimonials]").forEach((root) => {
    const slider = root.querySelector(".testimonials-slider");
    if (!slider) {
        return;
    }

    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const count = slider.querySelectorAll(".swiper-slide").length;

    new Swiper(slider, {
        modules: [Navigation],
        slidesPerView: 1,
        speed: reduce ? 0 : 650,
        loop: count > 1,
        watchOverflow: true,
        navigation: {
            prevEl: root.querySelector(".testimonials-prev"),
            nextEl: root.querySelector(".testimonials-next"),
        },
    });
});
