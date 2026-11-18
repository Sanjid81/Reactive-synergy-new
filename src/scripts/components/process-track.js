import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import "swiper/css";

document.querySelectorAll("[data-process-track]").forEach((root) => {
    const slider = root.querySelector(".process-track-steps");
    if (!slider) {
        return;
    }

    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const count = slider.querySelectorAll(".swiper-slide").length;

    new Swiper(slider, {
        modules: [Navigation],
        slidesPerView: 1,
        spaceBetween: 18,
        speed: reduce ? 0 : 650,
        loop: count > 3,
        grabCursor: true,
        watchOverflow: true,
        navigation: {
            prevEl: root.querySelector(".process-track-prev"),
            nextEl: root.querySelector(".process-track-next"),
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 24,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 28,
            },
        },
    });
});
