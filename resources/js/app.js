const STORAGE_KEY = 'bde.sidebar';
const THEME_STORAGE_KEY = 'bde.theme';
const MOBILE_QUERY = '(max-width: 900px)';

const isMobile = () => window.matchMedia(MOBILE_QUERY).matches;

const isOpen = () => document.documentElement.dataset.sidebar !== 'closed';

const isDark = () => document.documentElement.dataset.theme === 'dark';

const setSidebarState = (open) => {
    document.documentElement.dataset.sidebar = open ? 'open' : 'closed';

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        const label = open ? 'Replier le menu' : 'Déplier le menu';

        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
    });

    if (isMobile()) {
        return;
    }

    try {
        window.localStorage.setItem(STORAGE_KEY, open ? 'open' : 'closed');
    } catch (error) {
    }
};

const bindSidebar = () => {
    if (!document.querySelector('.app-shell')) {
        return;
    }

    setSidebarState(isOpen());

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => setSidebarState(!isOpen()));
    });

    document.querySelectorAll('[data-sidebar-close]').forEach((element) => {
        element.addEventListener('click', () => setSidebarState(false));
    });

    document.querySelectorAll('.sidebar__nav a').forEach((link) => {
        link.addEventListener('click', () => {
            if (isMobile()) {
                setSidebarState(false);
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isMobile() && isOpen()) {
            setSidebarState(false);
        }
    });
};

const bindPasswordToggles = () => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const input = document.getElementById(button.getAttribute('aria-controls'));

        if (!input) {
            return;
        }

        button.addEventListener('click', () => {
            const visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            button.setAttribute('aria-label', visible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
            button.setAttribute('title', visible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
            button.querySelector('[data-password-icon="show"]').hidden = !visible;
            button.querySelector('[data-password-icon="hide"]').hidden = visible;
        });
    });
};

const setTheme = (dark) => {
    document.documentElement.dataset.theme = dark ? 'dark' : 'light';

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const label = dark ? 'Activer le mode clair' : 'Activer le mode sombre';

        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
        button.querySelector('[data-theme-icon="moon"]').hidden = dark;
        button.querySelector('[data-theme-icon="sun"]').hidden = !dark;
    });

    try {
        window.localStorage.setItem(THEME_STORAGE_KEY, dark ? 'dark' : 'light');
    } catch (error) {
    }
};

const bindThemeToggle = () => {
    if (!document.querySelector('[data-theme-toggle]')) {
        return;
    }

    setTheme(isDark());

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => setTheme(!isDark()));
    });
};

const bindApp = () => {
    bindSidebar();
    bindPasswordToggles();
    bindThemeToggle();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindApp);
} else {
    bindApp();
}
