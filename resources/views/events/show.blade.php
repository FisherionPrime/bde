@extends('template')

@section('titre', $event->name.' — Educia BDE')

@section('surtitre', 'Événement — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('index') }}">Retour aux événements</a>
@endsection

@section('contenu')
    <div class="page-head">
        <div class="card__accent" style="background: {{ $event->color }}"></div>
        <h1 class="page-head__title">{{ $event->name }}</h1>
        <p class="page-head__lead">{{ $event->event_date->translatedFormat('l j F Y') }}</p>
    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif

    <section aria-labelledby="event-students-title">
        <div class="section-heading">
            <h2 class="section-title" id="event-students-title">Élèves participants ({{ $event->students->count() }})</h2>
        </div>

        @if (auth()->user()->role === 'admin')
            <form class="form-panel" action="{{ route('events.participants.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                @forelse ($students as $student)
                    <label class="checkbox-row">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" @checked($event->students->contains($student->id))>
                        <span>{{ $student->last_name }} {{ $student->first_name }} — {{ $student->class_name }}</span>
                    </label>
                @empty
                    <p class="form-help">Aucun élève dans l’annuaire.</p>
                @endforelse

                <button class="btn btn--primary" type="submit">Enregistrer la liste</button>
            </form>
        @elseif ($event->students->isNotEmpty())
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->students as $student)
                            <tr>
                                <td>{{ $student->last_name }}</td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->class_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="empty-state">Aucun élève n’est encore associé à cet événement.</p>
        @endif
    </section>
@endsection
