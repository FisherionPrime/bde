@extends('template')

@section('titre', 'Participants — Educia BDE')

@section('surtitre', 'Vie étudiante — Educia BDE')

@section('actions')
    @if (auth()->user()->role === 'admin')
        <a class="btn btn--primary" href="{{ route('participants.create') }}">Ajouter un élève</a>
    @endif
@endsection

@section('contenu')
    <div class="page-head">
        <h1 class="page-head__title">Participants</h1>
        <p class="page-head__lead">Consulte l’annuaire des élèves et leur participation aux activités.</p>
    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table class="table participants-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Activités réalisées</th>
                    @if (auth()->user()->role === 'admin')
                        <th><span class="visually-hidden">Actions</span></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($participants as $participant)
                    <tr>
                        <td>{{ $participant->last_name ?: '—' }}</td>
                        <td>{{ $participant->first_name ?: $participant->name ?: '—' }}</td>
                        <td>{{ $participant->class_name ?: '—' }}</td>
                        <td>{{ $participant->events_count }}</td>
                        @if (auth()->user()->role === 'admin')
                            <td class="table__actions">
                                <a class="card__link" href="{{ route('participants.edit', $participant) }}">Modifier</a>
                                <form action="{{ route('participants.destroy', $participant) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-btn text-btn--danger" type="submit" onclick="return confirm('Supprimer cet élève ?')">Supprimer</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}">Aucun élève enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
