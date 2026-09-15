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
        <strong>67h</strong>
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
            <input class="input" type="password" id="password" name="password" required placeholder="Votre mot de passe">
        </div>

        <button class="btn btn--primary btn--block" type="submit">Connexion</button>
    </form>

    <p class="form-note">
        Pas de compte ? <a href="{{ route('auth.register') }}">S'inscrire</a>
    </p>
@endsection
