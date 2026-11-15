const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

if (reduce) {
    document.documentElement.classList.remove("has-motion");
} else {
    const nodes = document.querySelectorAll(".reveal");

    if (!nodes.length || !("IntersectionObserver" in window)) {
        nodes.forEach((node) => node.classList.add("is-in"));
    } else {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add("is-in");
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.16,
            rootMargin: "0px 0px -8% 0px",
        });

        nodes.forEach((node) => {
            if (node.closest("[hidden]")) {
                node.classList.add("is-in");
                return;
            }

            observer.observe(node);
        });
    }
}
