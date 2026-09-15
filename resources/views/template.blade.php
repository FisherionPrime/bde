<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('titre', config('app.name', 'Educia BDE'))</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}">

        <script>
            (() => {
                let stored = null;

                try {
                    stored = window.localStorage.getItem('bde.sidebar');
                } catch (error) {
                    // Stockage indisponible : on retombe sur la largeur de la fenêtre.
                }

                const open = window.innerWidth > 900 && stored !== 'closed';

                document.documentElement.dataset.sidebar = open ? 'open' : 'closed';
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="app-shell">
            <aside class="sidebar" id="sidebar" aria-label="Menu principal">
                <div class="sidebar__head">
                    <a class="brand sidebar__brand" href="{{ route('index') }}">
                        <img class="brand__logo" src="{{ asset('images/logo.png') }}" alt="">
                        <span class="brand__name">Educia BDE</span>
                    </a>

                    <button
                        class="icon-btn sidebar__toggle"
                        type="button"
                        data-sidebar-toggle
                        aria-controls="sidebar"
                        aria-expanded="true"
                        aria-label="Replier le menu"
                        title="Replier le menu"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 18l-6-6 6-6"></path>
                        </svg>
                    </button>
                </div>

                <nav class="sidebar__nav">
                    <a href="{{ route('index') }}" @class(['is-active' => request()->routeIs('index')])>Accueil</a>
                    <a href="{{ route('events.index') }}" @class(['is-active' => request()->routeIs('events.*')])>Événements</a>
                    @auth
                        <a href="{{ route('participants.index') }}" @class(['is-active' => request()->routeIs('participants.*')])>Participants</a>
                    @else
                        <a href="{{ route('index') }}#participants">Participants</a>
                    @endauth
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.*')])>Administration</a>
                        @endif
                    @endauth
                </nav>

                <div class="sidebar__footer">
                    <div class="sidebar__session">
                        <div class="sidebar__session-label">Session</div>
                        <div class="sidebar__session-value">
                            @auth
                                {{ auth()->user()->name ?: auth()->user()->email }}
                            @else
                                Visiteur
                            @endauth
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn--danger" type="submit">Déconnexion</button>
                        </form>
                    @else
                        <a class="btn btn--primary" href="{{ route('auth.login') }}">Connexion</a>
                    @endauth
                </div>
            </aside>

            <button class="sidebar__backdrop" type="button" data-sidebar-close aria-label="Fermer le menu"></button>

            <main class="app-main">
                <header class="app-header">
                    <p class="eyebrow">@yield('surtitre', 'Espace gestionnaires — Educia BDE')</p>

                    <div class="app-header__actions">
                        @yield('actions')

                        <button
                            class="icon-btn app-header__menu"
                            type="button"
                            data-sidebar-toggle
                            aria-controls="sidebar"
                            aria-expanded="false"
                            aria-label="Déplier le menu"
                            title="Déplier le menu"
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15 18l-6-6 6-6"></path>
                            </svg>
                        </button>
                    </div>
                </header>

                <div class="app-content">
                    @yield('contenu')
                </div>
            </main>
        </div>
    </body>
</html>
