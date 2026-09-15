@extends('template')

@section('titre', 'Ajouter un élève — Educia BDE')

@section('surtitre', 'Administration — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('participants.index') }}">Retour aux participants</a>
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Ajouter un élève</h1>
        <p class="page-head__lead">Ajoute un élève dans l’annuaire du BDE.</p>
    </div>

    <form class="form-panel" action="{{ route('participants.store') }}" method="POST">
        @csrf
        @include('participants._form', ['submitLabel' => 'Ajouter l’élève'])
    </form>
@endsection
