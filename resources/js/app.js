import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Dark mode functionality
document.addEventListener("DOMContentLoaded", () => {
    // Always set dark mode as default
    if (!localStorage.getItem("theme")) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    }

    // Ensure dark mode is applied if it's set in localStorage
    if (localStorage.theme === "dark" || !("theme" in localStorage)) {
        document.documentElement.classList.add("dark");
    }

    const darkModeToggle = document.querySelector("[data-dark-toggle]");
    if (darkModeToggle) {
        // Update button state based on current theme
        const updateButtonState = () => {
            const isDark = document.documentElement.classList.contains("dark");
            darkModeToggle.setAttribute("aria-checked", isDark.toString());
            darkModeToggle.setAttribute(
                "aria-label",
                `Switch to ${isDark ? "light" : "dark"} mode`
            );
        };

        // Initialize button state
        updateButtonState();

        // Handle click events
        darkModeToggle.addEventListener("click", () => {
            document.documentElement.classList.toggle("dark");
            const isDark = document.documentElement.classList.contains("dark");
            localStorage.setItem("theme", isDark ? "dark" : "light");
            updateButtonState();
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});

// Mobile menu functionality
const mobileMenuButton = document.querySelector("[data-mobile-menu]");
const mobileMenu = document.querySelector(".mobile-menu");
const openIcon = mobileMenuButton?.querySelector(".mobile-menu-open");
const closeIcon = mobileMenuButton?.querySelector(".mobile-menu-close");

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
        openIcon?.classList.toggle("hidden");
        closeIcon?.classList.toggle("hidden");
        document.body.classList.toggle("overflow-hidden");
    });

    // Close mobile menu when clicking on links
    mobileMenu.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            mobileMenu.classList.add("hidden");
            openIcon?.classList.remove("hidden");
            closeIcon?.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        });
    });
}
