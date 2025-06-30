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
document.addEventListener("DOMContentLoaded", () => {
    const mobileMenuButtons = document.querySelectorAll("[data-mobile-menu]");
    const mobileMenu = document.querySelector(".mobile-menu");
    const navbarMenuButton = document.querySelector(".md\\:hidden [data-mobile-menu]");
    const openIcon = navbarMenuButton?.querySelector(".mobile-menu-open");
    const closeIcon = navbarMenuButton?.querySelector(".mobile-menu-close");

    // Toggle mobile menu
    const toggleMobileMenu = () => {
        if (mobileMenu) {
            const isHidden = mobileMenu.classList.contains("hidden");
            
            if (isHidden) {
                mobileMenu.classList.remove("hidden");
                openIcon?.classList.add("hidden");
                closeIcon?.classList.remove("hidden");
                document.body.classList.add("overflow-hidden");
            } else {
                mobileMenu.classList.add("hidden");
                openIcon?.classList.remove("hidden");
                closeIcon?.classList.add("hidden");
                document.body.classList.remove("overflow-hidden");
            }
        }
    };

    // Add click listeners to all mobile menu buttons
    mobileMenuButtons.forEach((button) => {
        button.addEventListener("click", toggleMobileMenu);
    });

    // Close mobile menu when clicking on navigation links
    if (mobileMenu) {
        mobileMenu.querySelectorAll("a[href^='#']").forEach((link) => {
            link.addEventListener("click", () => {
                mobileMenu.classList.add("hidden");
                openIcon?.classList.remove("hidden");
                closeIcon?.classList.add("hidden");
                document.body.classList.remove("overflow-hidden");
            });
        });

        // Close mobile menu when clicking outside
        mobileMenu.addEventListener("click", (e) => {
            if (e.target === mobileMenu) {
                toggleMobileMenu();
            }
        });
    }

    // Handle escape key to close mobile menu
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && mobileMenu && !mobileMenu.classList.contains("hidden")) {
            toggleMobileMenu();
        }
    });
});
