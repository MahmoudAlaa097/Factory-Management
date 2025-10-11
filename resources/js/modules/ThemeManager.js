// resources/js/modules/ThemeManager.js

/**
 * Manages dark/light theme switching and persistence
 */
export default class ThemeManager {
    constructor() {
        this.storageKey = 'color-theme';
        this.darkClass = 'dark';
        this.toggleButtonId = 'theme-toggle';
        this.init();
    }

    /**
     * Initialize theme management
     */
    init() {
        // Apply theme immediately to prevent FOUC
        this.applyInitialTheme();

        // Set up toggle button when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            this.setupToggleButton();
            this.updateToggleIcons();
        });
    }

    /**
     * Apply theme before DOM loads
     */
    applyInitialTheme() {
        const theme = this.getCurrentTheme();

        if (theme === 'dark') {
            document.documentElement.classList.add(this.darkClass);
        } else {
            document.documentElement.classList.remove(this.darkClass);
        }
    }

    /**
     * Get current theme from localStorage or system preference
     * @returns {string} 'dark' or 'light'
     */
    getCurrentTheme() {
        const stored = localStorage.getItem(this.storageKey);
        if (stored) return stored;

        // Fall back to system preference
        return window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    /**
     * Set up the theme toggle button click handler
     */
    setupToggleButton() {
        const toggleBtn = document.getElementById(this.toggleButtonId);

        if (!toggleBtn) {
            console.warn(`Theme toggle button #${this.toggleButtonId} not found`);
            return;
        }

        toggleBtn.addEventListener('click', () => this.toggle());
    }

    /**
     * Toggle between dark and light theme
     */
    toggle() {
        const html = document.documentElement;
        const isDark = html.classList.contains(this.darkClass);

        if (isDark) {
            this.setTheme('light');
        } else {
            this.setTheme('dark');
        }
    }

    /**
     * Set specific theme
     * @param {string} theme - 'dark' or 'light'
     */
    setTheme(theme) {
        const html = document.documentElement;

        if (theme === 'dark') {
            html.classList.add(this.darkClass);
        } else {
            html.classList.remove(this.darkClass);
        }

        localStorage.setItem(this.storageKey, theme);
        this.updateToggleIcons();

        // Dispatch custom event for other components
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme }
        }));
    }

    /**
     * Update toggle button icons based on current theme
     */
    updateToggleIcons() {
        const toggleBtn = document.getElementById(this.toggleButtonId);
        if (!toggleBtn) return;

        const isDark = document.documentElement.classList.contains(this.darkClass);
        const darkIcon = toggleBtn.querySelector('.dark\\:inline');
        const lightIcon = toggleBtn.querySelector('.dark\\:hidden');

        if (darkIcon && lightIcon) {
            if (isDark) {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            }
        }
    }

    /**
     * Check if dark mode is currently active
     * @returns {boolean}
     */
    isDarkMode() {
        return document.documentElement.classList.contains(this.darkClass);
    }

    /**
     * Clear theme preference (will use system preference)
     */
    clearPreference() {
        localStorage.removeItem(this.storageKey);
        this.applyInitialTheme();
        this.updateToggleIcons();
    }
}
