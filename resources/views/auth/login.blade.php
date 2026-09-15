@extends('template-auth')

@section('titre', 'Connexion — Educia BDE')

@section('visuel-titre', 'Bienvenue sur Educia BDE')

@section('visuel-texte', 'Le site interne dédié aux gestionnaires du BDE pour organiser et suivre les activités et événements.')

@section('visuel-chiffres')
    <div class="stat">
        <strong>15+</strong>
        <span>événements</span>
    </div>
    <div class="stat">
        <strong>400+</strong>
        <span>étudiants</span>
    </div>
    <div class="stat">
        <strong>24h</strong>
        <span>de réponses</span>
    </div>
@endsection

@section('contenu')
    <h2 class="auth-panel__title">Se connecter</h2>
    <p class="auth-panel__lead">Rentre avec ton compte étudiant pour accéder à l’espace BDE.</p>

    @if (session('success'))
        <div class="alert alert--success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('auth.login.submit') }}" method="POST">
        @csrf

        <div class="field">
            <label class="field__label" for="email">Email</label>
            <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Votre email">
        </div>

        <div class="field">
            <label class="field__label" for="password">Mot de passe</label>
            <div class="input-with-action">
                <input class="input" type="password" id="password" name="password" required placeholder="Votre mot de passe">
                <button class="input-with-action__button" type="button" data-password-toggle aria-controls="password" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
                    <svg data-password-icon="show" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="2.5"></circle>
                    </svg>
                    <svg data-password-icon="hide" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" hidden>
                        <path d="m3 3 18 18"></path>
                        <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6.5 0 10 6 10 6a18.4 18.4 0 0 1-3.1 3.7"></path>
                        <path d="M6.7 6.7C3.7 8.3 2 12 2 12s3.5 6 10 6a10.7 10.7 0 0 0 4-.8"></path>
                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                    </svg>
                </button>
            </div>
        </div>

        <button class="btn btn--primary btn--block" type="submit">Connexion</button>
    </form>

    <p class="form-note">
        Pas de compte ? <a href="{{ route('auth.register') }}">S'inscrire</a>
    </p>
@endsection
