/**
 * Barre latérale repliable de la coquille applicative.
 *
 * L'état vit sur `<html data-sidebar>` : un script inline dans le template le
 * positionne avant le premier rendu pour éviter tout clignotement, ce module
 * ne fait que brancher les contrôles.
 */

const STORAGE_KEY = 'bde.sidebar';
const MOBILE_QUERY = '(max-width: 900px)';

const isMobile = () => window.matchMedia(MOBILE_QUERY).matches;

const isOpen = () => document.documentElement.dataset.sidebar !== 'closed';

const setSidebarState = (open) => {
    document.documentElement.dataset.sidebar = open ? 'open' : 'closed';

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        const label = open ? 'Replier le menu' : 'Déplier le menu';

        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
    });

    /** Sur mobile la barre est un tiroir temporaire : son état ne doit pas devenir la préférence bureau. */
    if (isMobile()) {
        return;
    }

    try {
        window.localStorage.setItem(STORAGE_KEY, open ? 'open' : 'closed');
    } catch (error) {
        // Stockage indisponible (navigation privée) : l'état reste valable pour la page.
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

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindSidebar);
} else {
    bindSidebar();
}
