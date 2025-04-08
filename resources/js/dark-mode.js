(function () {
    const root = document.documentElement;
    const savedTheme = localStorage.getItem("theme") || "system";

    function applyTheme(theme) {
        if (theme === "dark" || (theme === "system" && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
            root.setAttribute("data-theme", "dark");
        } else {
            root.setAttribute("data-theme", "light");
        }
    }

    // Appliquer le thème immédiatement pour éviter le flash
    applyTheme(savedTheme);

    document.addEventListener("DOMContentLoaded", function () {
        // Écouter les changements système si "system" est sélectionné
        if (savedTheme === "system") {
            window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
                applyTheme("system");
            });
        }

        // Ajouter les événements aux boutons de changement de thème
        document.querySelectorAll("[data-theme-toggle]").forEach((button) => {
            button.addEventListener("click", function () {
                const selectedTheme = this.getAttribute("data-theme-toggle");
                localStorage.setItem("theme", selectedTheme);
                applyTheme(selectedTheme);
            });
        });
    });
})();
