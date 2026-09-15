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
            background: #fcdda9;
            color: #2f0f43;
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
            background: linear-gradient(180deg, #fcdda9 0%, #f7521c 40%, #ef3a2f 100%);
            color: #4f116f;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
            box-shadow: 12px 0 28px rgba(79, 17, 111, 0.16);
            overflow-y: auto;
        }
        .dashboard-shell[data-menu-open='true'] .sidebar {
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
            border: 1px solid rgba(79, 17, 111, 0.24);
            border-radius: 12px;
            background: #ffffff;
            color: #4f116f;
            font-size: 1.35rem;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(79, 17, 111, 0.12);
        }
        .menu-toggle:hover,
        .menu-toggle:focus-visible {
            border-color: #ef3a2f;
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
        .dashboard-shell[data-menu-open='false'] .menu-backdrop {
            display: none;
        }
        .sidebar-brand {
            display: block;
            margin-bottom: 46px;
            color: #2f0f43;
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
            color: #2f0f43;
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
            background: rgba(239, 58, 47, 0.18);
            color: #4f116f;
        }
        .wrap {
            min-width: 0;
            padding: 84px 20px 80px;
        }
        .hero {
            background: #ffffff;
            color: #4f116f;
            border-radius: 28px;
            padding: 42px 32px;
            border: 1px solid rgba(79, 17, 111, 0.24);
            box-shadow: 0 20px 50px rgba(79, 17, 111, 0.12);
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
            color: #d51f5e;
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
            border: 1px solid rgba(79, 17, 111, 0.24);
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 15px 30px rgba(79, 17, 111, 0.1);
        }
        .card h3 {
            margin-top: 0;
            font-size: 1.1rem;
        }
        .card:nth-child(1) {
            border-top: 4px solid #f7521c;
        }
        .card:nth-child(2) {
            border-top: 4px solid #e52947;
        }
        .card:nth-child(3) {
            border-top: 4px solid #4f116f;
        }
        .badge {
            display: inline-block;
            margin-top: 18px;
            background: #d51f5e;
            color: #fff;
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
    <div class="dashboard-shell" data-menu-open="false">
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

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}">Administration</a>
                    @endif
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
                @auth
                    <div class="badge">Connecté en tant que {{ auth()->user()->name ?: auth()->user()->email }}</div>
                @endif
            </section>

            <div class="cards">
                <div class="card" id="evenements">
                    <h3>Événements</h3>
                    <p>Découvre les prochains rendez-vous culturels, sportifs et festifs.</p>
                </div>
                <div class="card" id="participants">
                    <h3>Participants</h3>
                    <p>Retrouve les membres, les équipes et les profils actifs de la communauté étudiante.</p>
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
                shell.setAttribute('data-menu-open', isOpen ? 'true' : 'false');
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
            };

            toggle.addEventListener('click', () => {
                setMenuState(shell.getAttribute('data-menu-open') !== 'true');
            });
            backdrop.addEventListener('click', () => setMenuState(false));
            menuLinks.forEach((link) => link.addEventListener('click', () => setMenuState(false)));
        })();
    </script>
</body>
</html>
