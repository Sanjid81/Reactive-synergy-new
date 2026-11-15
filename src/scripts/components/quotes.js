import Swiper from "swiper";
import { Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";

document.querySelectorAll("[data-quotes]").forEach((root) => {
    const slider = root.querySelector(".quote-slider");
    if (!slider) {
        return;
    }

    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    new Swiper(slider, {
        modules: [Pagination],
        slidesPerView: 1,
        speed: reduce ? 0 : 700,
        loop: false,
        watchOverflow: true,
        pagination: {
            el: root.querySelector(".quote-dots"),
            clickable: true,
        },
    });
});
