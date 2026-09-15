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
        <div class="page-shell">
            <main class="content-wrap">
                @yield('contenu')
            </main>
        </div>
    </body>
</html>
