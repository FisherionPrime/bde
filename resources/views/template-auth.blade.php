<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('titre', config('app.name', 'Educia BDE'))</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}">
        <script>
            (() => {
                let storedTheme = null;

                try {
                    storedTheme = window.localStorage.getItem('bde.theme');
                } catch (error) {
                    // Stockage indisponible : le thème clair reste le choix par défaut.
                }

                document.documentElement.dataset.theme = storedTheme === 'dark' ? 'dark' : 'light';
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="auth-page">
            <header class="auth-topbar">
                <a class="brand" href="{{ route('index') }}">
                    <img class="brand__logo" src="{{ asset('images/logo.png') }}" alt="">
                    <span class="brand__name">Educia BDE</span>
                </a>

                <div class="auth-topbar__actions">
                    <p class="eyebrow">Espace gestionnaires</p>

                    <button
                        class="icon-btn theme-toggle"
                        type="button"
                        data-theme-toggle
                        aria-label="Activer le mode sombre"
                        title="Activer le mode sombre"
                    >
                        <svg data-theme-icon="moon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 12.8A8.5 8.5 0 1 1 11.2 3 6.5 6.5 0 0 0 21 12.8Z"></path>
                        </svg>
                        <svg data-theme-icon="sun" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" hidden>
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                        </svg>
                        <span class="visually-hidden">Changer de thème</span>
                    </button>
                </div>
            </header>

            <main class="auth-grid">
                <section class="auth-visual">
                    <div>
                        <span class="pill">@yield('visuel-pastille', 'BDE')</span>
                        <h1 class="auth-visual__title">@yield('visuel-titre')</h1>
                        <p class="auth-visual__lead">@yield('visuel-texte')</p>
                    </div>

                    <div class="stat-grid">
                        @yield('visuel-chiffres')
                    </div>
                </section>

                <section class="auth-panel">
                    <div class="auth-panel__inner">
                        @yield('contenu')
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
