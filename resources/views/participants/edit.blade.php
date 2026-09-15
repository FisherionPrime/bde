@extends('template')

@section('titre', 'Modifier un élève — Educia BDE')

@section('surtitre', 'Administration — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('participants.index') }}">Retour aux participants</a>
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Modifier un élève</h1>
        <p class="page-head__lead">Mets à jour les informations de cet élève.</p>
    </div>

    <form class="form-panel" action="{{ route('participants.update', $participant) }}" method="POST">
        @csrf
        @method('PUT')
        @include('participants._form', ['submitLabel' => 'Enregistrer les modifications'])
    </form>
@endsection
