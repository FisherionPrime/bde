<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDE - Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #EFEFEF;
            color: #000000;
        }
        .dashboard-shell {
            position: relative;
            display: block;
            width: 100%;
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 20;
            width: 230px;
            padding: 34px 20px;
            background: #E6A9B4;
            color: #481076;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
            box-shadow: 12px 0 28px rgba(72, 16, 118, 0.12);
            overflow-y: auto;
        }
        .dashboard-shell.menu-open .sidebar {
            transform: translateX(0);
        }
        .menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 12;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 1px solid rgba(69, 123, 157, 0.3);
            border-radius: 12px;
            background: #ffffff;
            color: #481076;
            font-size: 1.35rem;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(72, 16, 118, 0.1);
        }
        .menu-toggle:hover,
        .menu-toggle:focus-visible {
            border-color: #457B9D;
        }
        .menu-backdrop {
            position: fixed;
            inset: 0;
            z-index: 15;
            border: 0;
            padding: 0;
            background: rgba(0, 0, 0, 0.22);
            cursor: pointer;
        }
        .dashboard-shell:not(.menu-open) .menu-backdrop {
            display: none;
        }
        .sidebar-brand {
            display: block;
            margin-bottom: 46px;
            color: #000000;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
        }
        .sidebar-nav {
            display: grid;
            gap: 8px;
        }
        .sidebar-nav a,
        .sidebar-nav button {
            padding: 11px 13px;
            border-radius: 10px;
            color: #000000;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            font-family: inherit;
            border: none;
            background: transparent;
            text-align: left;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a[aria-current="page"],
        .sidebar-nav button:hover {
            background: rgba(69, 123, 157, 0.16);
            color: #481076;
        }
        .wrap {
            min-width: 0;
            padding: 84px 20px 80px;
        }
        .hero {
            background: #ffffff;
            color: #481076;
            border-radius: 28px;
            padding: 42px 32px;
            border: 1px solid rgba(69, 123, 157, 0.3);
            box-shadow: 0 20px 50px rgba(72, 16, 118, 0.1);
        }
        .hero h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            margin: 0 0 12px;
        }
        .hero p {
            font-size: 1.05rem;
            line-height: 1.7;
            margin: 0;
            max-width: 700px;
            color: #457B9D;
        }
        .cards {
            margin-top: 32px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
            padding-top: 4px;
        }
        .card {
            background: #ffffff;
            border: 1px solid rgba(69, 123, 157, 0.25);
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 15px 30px rgba(72, 16, 118, 0.08);
        }
        .card h3 {
            margin-top: 0;
            font-size: 1.1rem;
        }
        .card:nth-child(1) {
            border-top: 4px solid #F75C1D;
        }
        .card:nth-child(2) {
            border-top: 4px solid #457B9D;
        }
        .card:nth-child(3) {
            border-top: 4px solid #590D6A;
        }
        .badge {
            display: inline-block;
            margin-top: 18px;
            background: #F7A38A;
            color: #481076;
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 0.8rem;
        }
        @media (max-width: 720px) {
            .sidebar {
                padding: 20px;
            }
            .sidebar-brand {
                margin-bottom: 18px;
            }
            .sidebar-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }
            .sidebar-nav a,
            .sidebar-nav button {
                width: auto;
                flex: 1 1 130px;
            }
            .wrap {
                padding: 80px 16px 48px;
            }
            .hero {
                padding: 28px 20px;
                border-radius: 20px;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .cards {
                grid-template-columns: 1fr;
                gap: 14px;
                margin-top: 20px;
            }
            .card {
                border-radius: 16px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-shell">
        <button class="menu-toggle" type="button" aria-controls="main-menu" aria-expanded="false" aria-label="Ouvrir le menu">
            <span aria-hidden="true">&#9776;</span>
        </button>
        <button class="menu-backdrop" type="button" aria-label="Fermer le menu"></button>

        <aside class="sidebar" id="main-menu" aria-label="Menu principal">
            <a class="sidebar-brand" href="{{ route('index') }}">Educia BDE</a>
            <nav class="sidebar-nav">
                <a href="{{ route('index') }}" aria-current="page">Accueil</a>
                <a href="#evenements">Événements</a>
                <a href="#participants">Participants</a>
                <a href="#communaute">Communauté</a>

                @if (session('user_id'))
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}">Connexion</a>
                @endif
            </nav>
        </aside>

        <main class="wrap">
            <section class="hero">
                <h1>Bienvenue sur Educia BDE</h1>
                <p>
                    Le site d’animation de la vie étudiante : événements, sorties, infos, bons plans
                    et toute la communauté du BDE en un seul endroit.
                </p>
                @if (session('user_name') || session('user_email'))
                    <div class="badge">Connecté en tant que {{ session('user_name') ?: session('user_email') }}</div>
                @endif
            </section>

            <div class="cards">
                <div class="card" id="evenements">
                    <h3>Événements</h3>
                    <p>Découvre les prochains rendez-vous culturels, sportifs et festifs.</p>
                </div>
                <div class="card" id="sorties">
                    <h3>Sorties</h3>
                    <p>Organise des soirées, des visites et des challenges entre étudiants.</p>
                </div>
                <div class="card" id="communaute">
                    <h3>Communauté</h3>
                    <p>Reste connecté avec ton BDE et partage les bonnes initiatives.</p>
                </div>
            </div>
        </main>
    </div>
    <script>
        (() => {
            const shell = document.querySelector('.dashboard-shell');
            const toggle = document.querySelector('.menu-toggle');
            const backdrop = document.querySelector('.menu-backdrop');
            const menuLinks = document.querySelectorAll('.sidebar a, .sidebar button');

            const setMenuState = (isOpen) => {
                shell.classList.toggle('menu-open', isOpen);
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
            };

            toggle.addEventListener('click', () => {
                setMenuState(!shell.classList.contains('menu-open'));
            });
            backdrop.addEventListener('click', () => setMenuState(false));
            menuLinks.forEach((link) => link.addEventListener('click', () => setMenuState(false)));
        })();
    </script>
</body>
</html>
