@extends('template')

@section('titre', 'Nouvel événement — Educia BDE')

@section('surtitre', 'Administration — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('admin.dashboard') }}">Retour au tableau de bord</a>
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Créer un événement</h1>
        <p class="page-head__lead">Ajoute un rendez-vous au calendrier du BDE.</p>
    </div>

    @if ($errors->any())
        <div class="alert" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-panel" action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="field">
            <label class="field__label" for="name">Nom de l’événement</label>
            <input class="input" id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" autofocus>
        </div>

        <div class="field">
            <label class="field__label" for="color">Couleur de l’événement</label>
            <input class="input" id="color" name="color" type="color" value="{{ old('color', '#f7521c') }}" required>
        </div>

        <div class="field">
            <label class="field__label" for="event_date">Date</label>
            <input class="input" id="event_date" name="event_date" type="date" value="{{ old('event_date') }}" required>
        </div>

        <fieldset class="field event-selector">
            <legend class="field__label">Élèves participants</legend>
            @forelse ($students as $student)
                <label class="checkbox-row">
                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" @checked(in_array($student->id, old('student_ids', [])))>
                    <span>{{ $student->last_name }} {{ $student->first_name }} — {{ $student->class_name }}</span>
                </label>
            @empty
                <p class="form-help">Ajoute d’abord des élèves dans la page Participants.</p>
            @endforelse
        </fieldset>

        <button class="btn btn--primary" type="submit">Créer l’événement</button>
    </form>
@endsection
