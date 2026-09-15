@extends('template')

@section('titre', 'Accueil — Educia BDE')

@section('actions')
    @auth
        <a class="btn btn--icon" href="{{ route('participants.export') }}" aria-label="Exporter la liste des participants en PDF" title="Exporter la liste des participants en PDF">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 21V9"></path>
                <path d="m7 14 5-5 5 5"></path>
                <path d="M4 3h16"></path>
            </svg>
        </a>
    @endauth
    @auth
        @if (auth()->user()->role === 'admin')
            <a class="btn btn--primary" href="{{ route('events.create') }}">Nouvel événement</a>
        @endif
    @endauth
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Bienvenue sur Educia BDE</h1>
        <p class="page-head__lead">
            Le site d’animation de la vie étudiante : événements, sorties, infos, bons plans
            et toute la communauté du BDE en un seul endroit.
        </p>

        @auth
            <span class="page-head__badge">Connecté en tant que {{ auth()->user()->name ?: auth()->user()->email }}</span>
        @endauth
    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif

    <section class="events-section" aria-labelledby="events-title">
        <div class="section-heading">
            <h2 class="section-title" id="events-title">Prochains événements</h2>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a class="card__link" href="{{ route('events.create') }}">Ajouter un événement →</a>
                @endif
            @endauth
        </div>

        @if ($events->isNotEmpty())
            <div class="card-grid">
                @foreach ($events as $event)
                    <article class="card event-card">
                        <div class="card__accent" style="background: {{ $event->color }}"></div>
                        <h3 class="card__title">{{ $event->name }}</h3>
                        <p class="card__text">{{ $event->event_date->translatedFormat('l j F Y') }}</p>
                        <a class="card__link" href="{{ route('events.show', $event) }}">Voir les participants →</a>
                    </article>
                @endforeach
            </div>
            <a class="btn events-section__more" href="{{ route('events.index') }}">Voir plus d’événements</a>
        @else
            <p class="empty-state">Aucun événement n’est encore programmé.</p>
        @endif
    </section>

    <section class="quick-access" aria-labelledby="quick-access-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Accès rapides</p>
                <h2 class="section-title" id="quick-access-title">Tout ce qu’il te faut pour le BDE</h2>
            </div>
        </div>

        <div class="card-grid">
            <article class="card quick-card">
                <div class="card__accent card__accent--orange"></div>
                <h3 class="card__title">Le calendrier complet</h3>
                <p class="card__text">Retrouve tous les événements et ouvre leur fiche pour gérer les participants.</p>
                <a class="card__link" href="{{ route('events.index') }}">Voir le calendrier →</a>
            </article>

            <article class="card quick-card" id="participants">
                <div class="card__accent card__accent--pink"></div>
                <h3 class="card__title">Les participants</h3>
                <p class="card__text">Consulte les membres et les profils étudiants inscrits dans la communauté.</p>
                @auth
                    <a class="card__link" href="{{ route('participants.index') }}">Voir les participants →</a>
                @else
                    <a class="card__link" href="{{ route('auth.login') }}">Se connecter pour consulter →</a>
                @endauth
            </article>

            @auth
                @if (auth()->user()->role === 'admin')
                    <article class="card quick-card">
                        <div class="card__accent card__accent--violet"></div>
                        <h3 class="card__title">Piloter le BDE</h3>
                        <p class="card__text">Accède aux outils d’administration pour organiser les événements et les participants.</p>
                        <a class="card__link" href="{{ route('admin.dashboard') }}">Ouvrir l’administration →</a>
                    </article>
                @endif
            @endauth
        </div>
    </section>
@endsection
