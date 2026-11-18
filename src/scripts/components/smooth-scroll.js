import Lenis from "lenis";
import "lenis/dist/lenis.css";

function headerOffset() {
    const header = document.querySelector(".site-header");
    if (!header) {
        return 0;
    }

    return -Math.ceil(header.getBoundingClientRect().height + 12);
}

const lenis = new Lenis({
    autoRaf: true,
    lerp: 0.085,
    smoothWheel: true,
    syncTouch: true,
    syncTouchLerp: 0.09,
    touchInertiaExponent: 1.4,
    allowNestedScroll: true,
    stopInertiaOnNavigate: true,
    anchors: {
        offset: headerOffset(),
    },
});

window.addEventListener("resize", () => {
    if (lenis.options.anchors && typeof lenis.options.anchors === "object") {
        lenis.options.anchors.offset = headerOffset();
    }
});

document.querySelectorAll("dialog").forEach((dialog) => {
    dialog.addEventListener("toggle", () => {
        if (dialog.open) {
            lenis.stop();
            return;
        }

        lenis.start();
    });
});
