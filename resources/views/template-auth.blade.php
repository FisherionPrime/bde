<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('titre', config('app.name', 'Educia BDE'))</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="auth-page">
            <header class="auth-topbar">
                <a class="brand" href="{{ route('index') }}">
                    <img class="brand__logo" src="{{ asset('images/logo.png') }}" alt="">
                    <span class="brand__name">Educia BDE</span>
                </a>

                <p class="eyebrow">Espace gestionnaires</p>
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
