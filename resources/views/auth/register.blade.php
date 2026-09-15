@extends('template-auth')

@section('titre', 'Inscription — Educia BDE')

@section('visuel-pastille', 'Campus life')

@section('visuel-titre', 'Rejoins la communauté étudiante')

@section('visuel-texte', 'Crée ton compte pour participer aux événements, obtenir les infos les plus fraîches et vivre pleinement ton année universitaire.')

@section('visuel-chiffres')
    <div class="stat">
        <strong>1 min</strong>
        <span>pour créer ton compte</span>
    </div>
    <div class="stat">
        <strong>24/7</strong>
        <span>informations</span>
    </div>
    <div class="stat">
        <strong>100%</strong>
        <span>à ta place</span>
    </div>
@endsection

@section('contenu')
    <h2 class="auth-panel__title">S'inscrire</h2>
    <p class="auth-panel__lead">Remplis le formulaire et rejoins dès maintenant la vie du campus.</p>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auth.register.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="field">
                <label class="field__label" for="first_name">Prénom</label>
                <input class="input" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="Votre prénom">
            </div>

            <div class="field">
                <label class="field__label" for="last_name">Nom</label>
                <input class="input" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Votre nom">
            </div>
        </div>

        <div class="field">
            <label class="field__label" for="class_name">Classe</label>
            <input class="input" type="text" id="class_name" name="class_name" value="{{ old('class_name') }}" required placeholder="Ex. B3 Informatique">
        </div>

        <div class="field">
            <label class="field__label" for="email">Email</label>
            <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Votre email">
        </div>

        <div class="field">
            <label class="field__label" for="password">Mot de passe</label>
            <input class="input" type="password" id="password" name="password" required placeholder="Minimum 6 caractères">
        </div>

        <div class="field">
            <label class="field__label" for="password_confirmation">Confirmer le mot de passe</label>
            <input class="input" type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirmez votre mot de passe">
        </div>

        <button class="btn btn--primary btn--block" type="submit">S'inscrire</button>
    </form>

    <p class="form-note">
        Déjà un compte ? <a href="{{ route('auth.login') }}">Se connecter</a>
    </p>
@endsection
