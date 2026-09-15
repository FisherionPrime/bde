<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'BDE') }}</title>
        <style>
            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }

            html, body {
                margin: 0;
                min-height: 100%;
                font-family: Arial, Helvetica, sans-serif;
                background: #efefef;
                color: #2f0f43;
            }

            body {
                min-height: 100vh;
                padding: 32px 20px;
            }

            .page-shell {
                max-width: 1240px;
                margin: 0 auto;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 18px 26px;
                border: 1px solid rgba(79, 17, 111, 0.2);
                background: #ffffff;
                margin-bottom: 26px;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 700;
                letter-spacing: 0.02em;
            }

            .brand-mark {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                object-fit: contain;
                border-radius: 14px;
                background: #ffffff;
                color: #4f116f;
                font-size: 0.9rem;
                box-shadow: 0 10px 22px rgba(229, 41, 71, 0.22);
            }

            .topnav {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }

            .topnav a {
                text-decoration: none;
                padding: 10px 16px;
                border-radius: 12px;
                color: #2f0f43;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .topnav a:hover {
                background: rgba(239, 58, 47, 0.12);
            }

            .topnav .primary {
                background: #d51f5e;
                color: #ffffff;
                box-shadow: 0 10px 24px rgba(213, 31, 94, 0.28);
            }

            .topnav .primary:hover {
                transform: translateY(-1px);
            }

            .content-wrap {
                display: block;
            }

            .auth-stage {
                min-height: calc(100vh - 150px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px 0;
            }

            .glass-card {
                width: min(100%, 940px);
                background: #ffffff;
                border: 1px solid rgba(79, 17, 111, 0.2);
                box-shadow: 0 24px 80px rgba(79, 17, 111, 0.12);
                border-radius: 32px;
                overflow: hidden;
            }

            .auth-layout {
                display: grid;
                grid-template-columns: 1.1fr 1fr;
            }

            .auth-visual {
                position: relative;
                min-height: 680px;
                background: #efefef;
                padding: 52px 34px;
                color: #2f0f43;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .auth-visual::before {
                content: '';
                position: absolute;
                inset: 24px;
                border: 1px solid rgba(79, 17, 111, 0.2);
                border-radius: 24px;
            }

            .visual-content {
                position: relative;
                z-index: 1;
            }

            .eyebrow {
                display: inline-block;
                padding: 8px 12px;
                border-radius: 999px;
                background: #ffffff;
                border: 1px solid rgba(79, 17, 111, 0.24);
                color: #4f116f;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            h1 {
                font-size: clamp(2rem, 4vw, 3.2rem);
                margin: 22px 0 16px;
                line-height: 1.05;
            }

            .lead {
                font-size: 1.05rem;
                line-height: 1.75;
                color: #d51f5e;
                max-width: 420px;
            }

            .stats {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
            }

            .stat {
                border-radius: 18px;
                padding: 18px 16px;
                background: rgba(255, 255, 255, 0.72);
                border: 1px solid rgba(79, 17, 111, 0.2);
            }

            .stat strong {
                display: block;
                font-size: 1.5rem;
                margin-bottom: 5px;
            }

            .auth-form-panel {
                background: #ffffff;
                padding: clamp(24px, 4vw, 52px);
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .form-wrap {
                max-width: 420px;
                width: 100%;
                margin: 0 auto;
            }

            .form-wrap h2 {
                margin: 0 0 8px;
                font-size: clamp(1.8rem, 2.3vw, 2.4rem);
            }

            .form-wrap p {
                margin: 0 0 28px;
                color: #d51f5e;
            }

            .input-group {
                margin-bottom: 18px;
            }

            .input-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 700;
                font-size: 0.92rem;
                color: #2f0f43;
            }

            .input-field {
                width: 100%;
                max-width: 100%;
                min-width: 0;
                border: 1px solid rgba(79, 17, 111, 0.3);
                border-radius: 14px;
                padding: 14px 16px;
                font-size: 1rem;
                background: #ffffff;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .input-field:focus {
                outline: none;
                border-color: #ef3a2f;
                box-shadow: 0 0 0 4px rgba(239, 58, 47, 0.2);
            }

            .primary-button {
                width: 100%;
                max-width: 100%;
                border: none;
                border-radius: 14px;
                padding: 15px 18px;
                font-size: 1rem;
                font-weight: 700;
                color: #fff;
                background: #d51f5e;
                box-shadow: 0 14px 30px rgba(213, 31, 94, 0.28);
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .primary-button:hover {
                transform: translateY(-1px);
                box-shadow: 0 18px 32px rgba(79, 17, 111, 0.24);
            }

            .text-link {
                color: #d51f5e;
                font-weight: 700;
                text-decoration: none;
            }

            .text-link:hover {
                text-decoration: underline;
            }

            .inline-note {
                margin-top: 22px;
                text-align: center;
                color: #d51f5e;
                font-size: 0.96rem;
            }

            .alert-box {
                background: #ffffff;
                border: 1px solid rgba(229, 41, 71, 0.65);
                color: #4f116f;
                border-radius: 14px;
                padding: 14px 16px;
                margin-bottom: 18px;
                font-weight: 600;
            }

            @media (max-width: 900px) {
                .auth-layout {
                    grid-template-columns: 1fr;
                }

                .auth-visual {
                    min-height: 320px;
                }

                .auth-form-panel {
                    padding: 36px 28px;
                }

                .topbar {
                    padding: 14px 18px;
                }
            }

            @media (max-width: 600px) {
                body {
                    padding: 16px;
                }

                .topbar {
                    align-items: stretch;
                    flex-direction: column;
                    gap: 14px;
                    padding: 14px;
                    margin-bottom: 16px;
                }

                .topnav {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 8px;
                }

                .topnav a {
                    padding: 10px 8px;
                    text-align: center;
                }

                .auth-stage {
                    min-height: auto;
                    padding: 8px 0 20px;
                }

                .glass-card {
                    border-radius: 20px;
                }

                .auth-visual {
                    min-height: auto;
                    padding: 32px 24px 28px;
                }

                .auth-visual::before {
                    inset: 16px;
                    border-radius: 16px;
                }

                h1 {
                    font-size: 2.25rem;
                }

                .lead {
                    font-size: 1rem;
                }

                .stats {
                    gap: 8px;
                    margin-top: 28px;
                }

                .stat {
                    padding: 12px 10px;
                    border-radius: 12px;
                    font-size: 0.82rem;
                }

                .stat strong {
                    font-size: 1.2rem;
                }

                .auth-form-panel {
                    padding: 30px 20px 26px;
                }

                .form-wrap h2 {
                    font-size: 1.9rem;
                }

                .form-wrap p {
                    margin-bottom: 22px;
                }
            }
        </style>
    </head>
    <body>
        <div class="page-shell">
            <main class="content-wrap">
                @yield('contenu')
            </main>
        </div>
    </body>
</html>
