@extends('template')

@section('contenu')
<section class="auth-stage">
    <div class="glass-card auth-layout">
        <div class="auth-visual">
            <div class="visual-content">
                <span class="eyebrow">BDE</span>
                <h1>Skolae Toulon</h1>
                <p class="lead">
                    Le site interne dédié aux gestionnaires du BDE pour organiser et suivre les activités et événements.
                </p>
            </div>

            <div class="stats">
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
            </div>
        </div>

        <div class="auth-form-panel">
            <div class="form-wrap">
                <h2>Se connecter</h2>
                <p>Rentre avec ton compte étudiant pour accéder à l’espace BDE.</p>

                @if ($errors->any())
                    <div class="alert-box">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('auth.login.submit') }}" method="POST">
                    @csrf

                    <div class="input-group">
                        <label class="input-label" for="email">Email</label>
                        <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Votre email">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="password">Mot de passe</label>
                        <input class="input-field" type="password" id="password" name="password" required placeholder="Votre mot de passe">
                    </div>

                    <button class="primary-button" type="submit">Connexion</button>
                </form>

                <p class="inline-note">
                    Pas de compte ? <a class="text-link" href="{{ route('auth.register') }}">S'inscrire</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
