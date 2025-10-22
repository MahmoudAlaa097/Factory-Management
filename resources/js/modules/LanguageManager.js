// resources/js/modules/LanguageManager.js

/**
 * @typedef {Object} LanguageManagerConfig
 * @property {Object<string, Object>} [translations={}] - Client-side translations
 * @property {string} [defaultLang='ar'] - Default language
 * @property {string} [storageKey='lang'] - localStorage key
 * @property {string} [toggleButtonId='lang-toggle'] - Button element ID
 * @property {string[]} [rtlLanguages=['ar','he','fa','ur']] - RTL language codes
 */

/**
 * Manages language/locale switching and RTL/LTR direction
 * Integrates with Laravel's server-side locale management
 */
export default class LanguageManager {
    /**
     * @param {LanguageManagerConfig} config
     */
    constructor(config = {}) {
        this.storageKey = config.storageKey || 'lang';
        this.translations = config.translations || {};
        this.defaultLang = config.defaultLang || 'ar';
        this.toggleButtonId = config.toggleButtonId || 'lang-toggle';
        this.rtlLanguages = config.rtlLanguages || ['ar', 'he', 'fa', 'ur'];
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

        // Sync when navigating with back/forward buttons
        window.addEventListener('pageshow', () => {
            this.syncWithServer();
        });
    }

    /**
     * Apply initial language from server or localStorage
     */
    applyInitialLanguage() {
        // CRITICAL: Check if HTML already has lang/dir set by Laravel (server-side)
        const htmlLang = document.documentElement.getAttribute('lang');
        const htmlDir = document.documentElement.getAttribute('dir');

        // If server already set the language, sync localStorage and DON'T override
        if (htmlLang && htmlDir) {
            this.syncWithServer();
            return;
        }

        // Fallback: Only apply client-side if server didn't set it (SPA pages, etc.)
        const lang = this.getCurrentLanguage();
        this.setLanguage(lang, false);
    }

    /**
     * Manually sync localStorage with server-rendered locale
     * Useful after navigation or dynamic content loading
     * @returns {string|null} The synced language or null
     */
    syncWithServer() {
        const serverLang = document.documentElement.getAttribute('lang');
        const serverDir = document.documentElement.getAttribute('dir');

        if (serverLang) {
            const storedLang = localStorage.getItem(this.storageKey);

            if (storedLang !== serverLang) {
                console.log(`[LanguageManager] Syncing: ${storedLang} → ${serverLang}`);
                localStorage.setItem(this.storageKey, serverLang);
            }

            // Ensure HTML attributes are correct
            if (serverDir) {
                document.documentElement.setAttribute('dir', serverDir);
            }

            return serverLang;
        }

        return null;
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
            console.warn(`[LanguageManager] Language toggle button #${this.toggleButtonId} not found`);
            return;
        }

        langBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default link behavior

            try {
                this.toggle();
            } catch (error) {
                console.error('[LanguageManager] Toggle failed:', error);
                // Fallback: reload page
                window.location.reload();
            }
        });
    }

    /**
     * Toggle between languages (currently ar/en, but extensible)
     */
    toggle() {
        const currentLang = document.documentElement.getAttribute('lang') || this.getCurrentLanguage();
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        this.setLanguage(newLang, true);
    }

    /**
     * Set specific language
     * @param {string} lang - Language code (e.g., 'ar', 'en')
     * @param {boolean} shouldReload - Whether to reload page for server-side translations
     */
    setLanguage(lang, shouldReload = false) {
        // Validate language
        if (!lang || typeof lang !== 'string') {
            console.error('[LanguageManager] Invalid language code:', lang);
            return;
        }

        const html = document.documentElement;

        // Update HTML attributes
        html.setAttribute('lang', lang);
        html.setAttribute('dir', this.isRTL(lang) ? 'rtl' : 'ltr');

        // Store preference
        localStorage.setItem(this.storageKey, lang);

        // Translate page elements if translations available
        this.translatePage(lang);

        // Dispatch custom event for other scripts to listen to
        window.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { language: lang, direction: this.isRTL(lang) ? 'rtl' : 'ltr' }
        }));

        // For Laravel apps, redirect to language switch route
        if (shouldReload || this.shouldReloadOnChange()) {
            // Use Laravel route instead of location.reload()
            window.location.href = `/lang/${lang}`;
            return;
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
     * @returns {boolean}
     */
    shouldReloadOnChange() {
        // Always reload if no client-side translations available
        if (Object.keys(this.translations).length === 0) {
            return true;
        }

        // Check if page has server-rendered content that needs translation
        const hasServerTranslations = document.querySelector('[data-server-translated]') !== null;

        return hasServerTranslations;
    }

    /**
     * Translate page elements using client-side translations
     * NOTE: Currently unused - app uses Laravel's __() for server-side translations
     * @param {string} lang
     */
    translatePage(lang) {
        // Skip if no translations provided
        if (!this.translations[lang] || Object.keys(this.translations[lang]).length === 0) {
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

    /**
     * Get all supported languages
     * @returns {string[]}
     */
    getSupportedLanguages() {
        return ['ar', 'en']; // Extend as needed
    }

    /**
     * Check if a language is supported
     * @param {string} lang
     * @returns {boolean}
     */
    isLanguageSupported(lang) {
        return this.getSupportedLanguages().includes(lang);
    }
}
