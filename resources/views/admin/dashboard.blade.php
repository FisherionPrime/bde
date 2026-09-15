@extends('template')

@section('titre', 'Administration — Educia BDE')

@section('surtitre', 'Administration — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('index') }}">Retour au site</a>
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Tableau de bord</h1>
        <p class="page-head__lead">
            Pilote la vie du BDE : événements, membres et communications du bureau.
        </p>
    </div>

    <div class="card-grid">
        <article class="card">
            <div class="card__accent card__accent--orange"></div>
            <h3 class="card__title">Événements</h3>
            <p class="card__text">Crée, planifie et suis les inscriptions aux rendez-vous du BDE.</p>
            <a class="card__link" href="{{ route('index') }}#evenements">Gérer le calendrier →</a>
        </article>

        <article class="card">
            <div class="card__accent card__accent--pink"></div>
            <h3 class="card__title">Membres</h3>
            <p class="card__text">Consulte les comptes étudiants et attribue les rôles du bureau.</p>
            <a class="card__link" href="{{ route('index') }}#participants">Voir les listes →</a>
        </article>

        <article class="card">
            <div class="card__accent card__accent--violet"></div>
            <h3 class="card__title">Communications</h3>
            <p class="card__text">Rédige les annonces diffusées sur l’espace étudiant.</p>
            <a class="card__link" href="{{ route('index') }}#communications">Publier une annonce →</a>
        </article>
    </div>
@endsection
