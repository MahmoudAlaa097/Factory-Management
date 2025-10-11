// resources/js/modules/LanguageManager.js

/**
 * Manages language/locale switching and RTL/LTR direction
 */
export default class LanguageManager {
    constructor(translations = {}) {
        this.storageKey = 'lang';
        this.translations = translations;
        this.defaultLang = 'ar';
        this.toggleButtonId = 'lang-toggle';
        this.rtlLanguages = ['ar', 'he', 'fa', 'ur']; // Add more RTL languages as needed
        this.init();
    }

    /**
     * Initialize language management
     */
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.applyInitialLanguage();
            this.setupToggleButton();
        });
    }

    /**
     * Apply initial language from localStorage or default
     */
    applyInitialLanguage() {
        const lang = this.getCurrentLanguage();
        this.setLanguage(lang, false);
    }

    /**
     * Get current language from localStorage or default
     * @returns {string}
     */
    getCurrentLanguage() {
        return localStorage.getItem(this.storageKey) || this.defaultLang;
    }

    /**
     * Set up the language toggle button click handler
     */
    setupToggleButton() {
        const langBtn = document.getElementById(this.toggleButtonId);

        if (!langBtn) {
            console.warn(`Language toggle button #${this.toggleButtonId} not found`);
            return;
        }

        langBtn.addEventListener('click', () => this.toggle());
    }

    /**
     * Toggle between languages (currently ar/en, but extensible)
     */
    toggle() {
        const currentLang = document.documentElement.getAttribute('lang');
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        this.setLanguage(newLang, true);
    }

    /**
     * Set specific language
     * @param {string} lang - Language code (e.g., 'ar', 'en')
     * @param {boolean} shouldReload - Whether to reload page for server-side translations
     */
    setLanguage(lang, shouldReload = false) {
        const html = document.documentElement;

        // Update HTML attributes
        html.setAttribute('lang', lang);
        html.setAttribute('dir', this.isRTL(lang) ? 'rtl' : 'ltr');

        // Store preference
        localStorage.setItem(this.storageKey, lang);

        // Translate page elements if translations available
        this.translatePage(lang);

        // Dispatch custom event
        window.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { language: lang }
        }));

        // Optional: reload for server-side translations
        if (shouldReload && this.shouldReloadOnChange()) {
            window.location.reload();
        }
    }

    /**
     * Check if language is RTL
     * @param {string} lang
     * @returns {boolean}
     */
    isRTL(lang) {
        return this.rtlLanguages.includes(lang);
    }

    /**
     * Determine if page should reload on language change
     * Override this method or set a property if you need different behavior
     * @returns {boolean}
     */
    shouldReloadOnChange() {
        // Don't reload on homepage or if translations are client-side only
        return Object.keys(this.translations).length === 0 && window.location.pathname !== '/';
    }

    /**
     * Translate page elements using client-side translations
     * @param {string} lang
     */
    translatePage(lang) {
        if (!this.translations[lang]) {
            return;
        }

        // Translate text content
        document.querySelectorAll('[data-translate]').forEach(el => {
            const key = el.getAttribute('data-translate');
            const translation = this.getNestedTranslation(lang, key);
            if (translation) {
                el.textContent = translation;
            }
        });

        // Translate placeholders
        document.querySelectorAll('[data-translate-placeholder]').forEach(el => {
            const key = el.getAttribute('data-translate-placeholder');
            const translation = this.getNestedTranslation(lang, key);
            if (translation) {
                el.setAttribute('placeholder', translation);
            }
        });

        // Translate aria-labels
        document.querySelectorAll('[data-translate-aria]').forEach(el => {
            const key = el.getAttribute('data-translate-aria');
            const translation = this.getNestedTranslation(lang, key);
            if (translation) {
                el.setAttribute('aria-label', translation);
            }
        });

        // Translate titles
        document.querySelectorAll('[data-translate-title]').forEach(el => {
            const key = el.getAttribute('data-translate-title');
            const translation = this.getNestedTranslation(lang, key);
            if (translation) {
                el.setAttribute('title', translation);
            }
        });
    }

    /**
     * Get nested translation using dot notation
     * @param {string} lang
     * @param {string} key - Can be nested like 'messages.welcome'
     * @returns {string|null}
     */
    getNestedTranslation(lang, key) {
        const keys = key.split('.');
        let value = this.translations[lang];

        for (const k of keys) {
            if (value && typeof value === 'object') {
                value = value[k];
            } else {
                return null;
            }
        }

        return typeof value === 'string' ? value : null;
    }

    /**
     * Add or update translations dynamically
     * @param {Object} newTranslations
     */
    addTranslations(newTranslations) {
        this.translations = this.deepMerge(this.translations, newTranslations);
    }

    /**
     * Deep merge objects
     * @param {Object} target
     * @param {Object} source
     * @returns {Object}
     */
    deepMerge(target, source) {
        const output = { ...target };

        if (this.isObject(target) && this.isObject(source)) {
            Object.keys(source).forEach(key => {
                if (this.isObject(source[key])) {
                    if (!(key in target)) {
                        output[key] = source[key];
                    } else {
                        output[key] = this.deepMerge(target[key], source[key]);
                    }
                } else {
                    output[key] = source[key];
                }
            });
        }

        return output;
    }

    /**
     * Check if value is an object
     * @param {*} item
     * @returns {boolean}
     */
    isObject(item) {
        return item && typeof item === 'object' && !Array.isArray(item);
    }

    /**
     * Get direction for current language
     * @returns {string} 'rtl' or 'ltr'
     */
    getCurrentDirection() {
        const lang = this.getCurrentLanguage();
        return this.isRTL(lang) ? 'rtl' : 'ltr';
    }
}
