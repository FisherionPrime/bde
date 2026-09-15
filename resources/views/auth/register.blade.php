@extends('template')

@section('contenu')
<section class="auth-stage">
    <div class="glass-card auth-layout">
        <div class="auth-visual">
            <div class="visual-content">
                <span class="eyebrow">Campus life</span>
                <h1>Rejoins la communauté étudiante.</h1>
                <p class="lead">
                    Crée ton compte pour participer aux événements, obtenir les infos les plus fraîches
                    et vivre pleinement ton année universitaire.
                </p>
            </div>

            <div class="stats">
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
            </div>
        </div>

        <div class="auth-form-panel">
            <div class="form-wrap">
                <h2>S'inscrire</h2>
                <p>Remplis le formulaire et rejoins dès maintenant la vie du campus.</p>

                @if ($errors->any())
                    <div class="alert-box">
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('auth.register.store') }}" method="POST">
                    @csrf

                    <div class="input-group">
                        <label class="input-label" for="name">Nom complet</label>
                        <input class="input-field" type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Votre nom">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="email">Email</label>
                        <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Votre email">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="password">Mot de passe</label>
                        <input class="input-field" type="password" id="password" name="password" required placeholder="Minimum 6 caractères">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="password_confirmation">Confirmer le mot de passe</label>
                        <input class="input-field" type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirmez votre mot de passe">
                    </div>

                    <button class="primary-button" type="submit">S'inscrire</button>
                </form>

                <p class="inline-note">
                    Déjà un compte ? <a class="text-link" href="{{ route('auth.login') }}">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
