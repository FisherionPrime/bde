@extends('template')

@section('titre', 'Événements — Educia BDE')

@section('surtitre', 'Calendrier — Educia BDE')

@section('actions')
    @if (auth()->user()->role === 'admin')
        <a class="btn btn--primary" href="{{ route('events.create') }}">Nouvel événement</a>
    @endif
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Tous les événements</h1>
        <p class="page-head__lead">Retrouve l’ensemble des rendez-vous du BDE.</p>
    </div>

    <form class="search-form" method="GET" action="{{ route('events.index') }}" role="search">
        <label class="visually-hidden" for="event-search">Rechercher un événement</label>
        <input class="input" id="event-search" name="q" type="search" value="{{ $search }}" placeholder="Rechercher un événement...">
        <button class="btn btn--primary" type="submit">Rechercher</button>
        @if ($search !== '')
            <a class="btn" href="{{ route('events.index') }}">Effacer</a>
        @endif
    </form>

    @if ($upcomingEvents->isNotEmpty())
        <section class="events-section" aria-labelledby="upcoming-events-title">
            <h2 class="section-title" id="upcoming-events-title">Événements à venir</h2>
            <div class="card-grid">
                @foreach ($upcomingEvents as $event)
                    <article class="card event-card">
                        <div class="card__accent" style="background: {{ $event->color }}"></div>
                        <h3 class="card__title">{{ $event->name }}</h3>
                        <p class="card__text">{{ $event->event_date->translatedFormat('l j F Y') }}</p>
                        <p class="card__text">{{ $event->students_count }} participant(s)</p>
                        <a class="card__link" href="{{ route('events.show', $event) }}">Voir les participants →</a>
                    </article>
                @endforeach
            </div>
        </section>
    @elseif ($archivedEvents->isEmpty())
        <p class="empty-state">Aucun événement ne correspond à ta recherche.</p>
    @endif

    @if ($archivedEvents->isNotEmpty())
        <section class="events-section events-section--archive" aria-labelledby="archived-events-title">
            <h2 class="section-title" id="archived-events-title">Archives</h2>
            <div class="card-grid">
                @foreach ($archivedEvents as $event)
                    <article class="card event-card event-card--archived">
                        <div class="card__accent" style="background: {{ $event->color }}"></div>
                        <h3 class="card__title">{{ $event->name }}</h3>
                        <p class="card__text">{{ $event->event_date->translatedFormat('l j F Y') }}</p>
                        <p class="card__text">{{ $event->students_count }} participant(s)</p>
                        <a class="card__link" href="{{ route('events.show', $event) }}">Voir les participants →</a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
