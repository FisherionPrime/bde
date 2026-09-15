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

    @if ($events->isNotEmpty())
        <div class="card-grid">
            @foreach ($events as $event)
                <article class="card event-card">
                    <div class="card__accent" style="background: {{ $event->color }}"></div>
                    <h2 class="card__title">{{ $event->name }}</h2>
                    <p class="card__text">{{ $event->event_date->translatedFormat('l j F Y') }}</p>
                    <a class="card__link" href="{{ route('events.show', $event) }}">Voir les participants →</a>
                </article>
            @endforeach
        </div>
    @else
        <p class="empty-state">Aucun événement n’est encore programmé.</p>
    @endif
@endsection
