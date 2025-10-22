import './bootstrap';
import ThemeManager from './modules/ThemeManager';
import LanguageManager from './modules/LanguageManager';

/**
 * Initialize Theme Management
 */
const themeManager = new ThemeManager();

/**
 * Initialize Language Management with configuration
 */
const languageManager = new LanguageManager({
    translations: window.translations || {},
    defaultLang: 'ar',
    storageKey: 'lang',
    toggleButtonId: 'lang-toggle',
    rtlLanguages: ['ar', 'he', 'fa', 'ur']
});

// Expose globally for debugging
window.themeManager = themeManager;
window.languageManager = languageManager;

// Optional: Listen to language change events
window.addEventListener('languageChanged', (e) => {
    console.log('[App] Language changed to:', e.detail.language);
    console.log('[App] Direction:', e.detail.direction);
});

// Optional: Listen for system theme changes
if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
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
