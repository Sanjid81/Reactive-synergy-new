import Swiper from "swiper";
import { Autoplay, Navigation } from "swiper/modules";
import "swiper/css";

document.querySelectorAll("[data-reasons]").forEach((root) => {
    const slider = root.querySelector(".reasons-slider");
    if (!slider) {
        return;
    }

    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    new Swiper(slider, {
        modules: [Navigation, Autoplay],
        slidesPerView: 1,
        spaceBetween: 30,
        speed: reduce ? 0 : 900,
        loop: true,
        grabCursor: true,
        watchOverflow: true,
        resistanceRatio: 0.65,
        autoplay: reduce ? false : {
            delay: 3200,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            prevEl: root.querySelector(".reasons-prev"),
            nextEl: root.querySelector(".reasons-next"),
        },
        breakpoints: {
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
});
