import './bootstrap';
import ThemeManager from './modules/ThemeManager';
import LanguageManager from './modules/LanguageManager';

/**
 * Initialize Theme Management
 */
const themeManager = new ThemeManager();

/**
 * Initialize Language Management
 * Pass translations if available from the backend
 */
const translations = window.translations || {};
const languageManager = new LanguageManager(translations);

/**
 * Export to window for global access if needed
 */
window.themeManager = themeManager;
window.languageManager = languageManager;

/**
 * Optional: Listen for system theme changes
 */
if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        // Only apply if user hasn't set a preference
        if (!localStorage.getItem('color-theme')) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            themeManager.updateToggleIcons();
        }
    });
}
