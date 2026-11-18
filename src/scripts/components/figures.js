const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const nodes = document.querySelectorAll(".figures-value[data-count]");

if (!reduce && nodes.length) {
    const parse = (value) => {
        const match = String(value).replace(/,/g, "").trim().match(/^(\d+(?:\.\d+)?)(.*)$/);
        if (!match) {
            return null;
        }

        return {
            target: Number(match[1]),
            suffix: match[2],
            decimals: (match[1].split(".")[1] || "").length,
        };
    };

    const format = (value, decimals, suffix) => {
        const number = decimals ? value.toFixed(decimals) : String(Math.round(value));
        return number + suffix;
    };

    const run = (live, parsed) => {
        const start = performance.now();
        const duration = 1600;

        const frame = (now) => {
            const progress = Math.min(1, (now - start) / duration);
            const eased = 1 - (1 - progress) ** 3;
            live.textContent = format(parsed.target * eased, parsed.decimals, parsed.suffix);
            if (progress < 1) {
                requestAnimationFrame(frame);
            }
        };

        live.textContent = format(0, parsed.decimals, parsed.suffix);
        requestAnimationFrame(frame);
    };

    const start = (node) => {
        const live = node.querySelector(".figures-value-live");
        const parsed = parse(node.dataset.count || "");
        if (!live || !parsed) {
            return;
        }
        run(live, parsed);
    };

    if (!("IntersectionObserver" in window)) {
        nodes.forEach(start);
    } else {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                start(entry.target);
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        nodes.forEach((node) => observer.observe(node));
    }
}
