@extends('template')

@section('titre', 'Accueil — Educia BDE')

@section('actions')
    <button class="btn" type="button">Exporter</button>
    <button class="btn btn--primary" type="button">Nouvel événement</button>
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
