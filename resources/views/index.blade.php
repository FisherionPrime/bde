@extends('template')

@section('titre', 'Accueil — Educia BDE')

@section('actions')
    <button class="btn btn--icon" type="button" aria-label="Importer des listes d'étudiants" title="Importer des listes d'étudiants">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 3v12"></path>
            <path d="M7 10l5 5 5-5"></path>
            <path d="M4 21h16"></path>
        </svg>
    </button>
    <button class="btn btn--icon" type="button" aria-label="Exporter des listes d'étudiants" title="Exporter des listes d'étudiants">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 21V9"></path>
            <path d="M7 14l5-5 5 5"></path>
            <path d="M4 3h16"></path>
        </svg>
    </button>
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
                    </article>
                @endforeach
            </div>
        @else
            <p class="empty-state">Aucun événement n’est encore programmé.</p>
        @endif
    </section>

    <div class="card-grid">
        <article class="card" id="evenements">
            <div class="card__accent card__accent--orange"></div>
            <h3 class="card__title">Événements</h3>
            <p class="card__text">Découvre les prochains rendez-vous culturels, sportifs et festifs.</p>
            <a class="card__link" href="{{ route('index') }}#evenements">Gérer le calendrier →</a>
        </article>

        <article class="card" id="participants">
            <div class="card__accent card__accent--pink"></div>
            <h3 class="card__title">Participants</h3>
            <p class="card__text">Retrouve les membres, les équipes et les profils actifs de la communauté étudiante.</p>
            <a class="card__link" href="{{ route('index') }}#participants">Voir les listes →</a>
        </article>

        <article class="card" id="communications">
            <div class="card__accent card__accent--violet"></div>
            <h3 class="card__title">Communications</h3>
            <p class="card__text">Reste connecté avec ton BDE et partage les bonnes initiatives.</p>
            <a class="card__link" href="{{ route('index') }}#communications">Publier une annonce →</a>
        </article>
    </div>
@endsection
