document.querySelectorAll(".library").forEach((root) => {
    const tabs = root.querySelectorAll("[data-library-tab]");
    const panels = root.querySelectorAll("[data-library-panel]");

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            const name = tab.dataset.libraryTab;
            tabs.forEach((item) => {
                const active = item === tab;
                item.classList.toggle("is-active", active);
                item.setAttribute("aria-selected", active ? "true" : "false");
            });
            panels.forEach((panel) => {
                panel.hidden = panel.dataset.libraryPanel !== name;
            });
        });
    });

    const dialog = root.querySelector("dialog");
    const frame = dialog ? dialog.querySelector("iframe") : null;
    const close = dialog ? dialog.querySelector("[data-library-close]") : null;

    root.querySelectorAll("[data-video-id]").forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.dataset.videoId;
            if (dialog && frame && id) {
                frame.src = "https://www.youtube.com/embed/" + id + "?autoplay=1";
                dialog.showModal();
                return;
            }
            if (button.dataset.videoUrl) {
                window.open(button.dataset.videoUrl, "_blank", "noopener");
            }
        });
    });

    if (close && dialog && frame) {
        close.addEventListener("click", () => dialog.close());
        dialog.addEventListener("close", () => {
            frame.src = "";
        });
        dialog.addEventListener("click", (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });
    }
});
