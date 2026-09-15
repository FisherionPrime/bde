@extends('template')

@section('titre', 'Participants — Educia BDE')

@section('surtitre', 'Vie étudiante — Educia BDE')

@section('actions')
    @if (auth()->user()->role === 'admin')
        <form class="import-form" action="{{ route('participants.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="btn" for="participants-file">Importer CSV</label>
            <input class="visually-hidden" id="participants-file" name="file" type="file" accept=".csv,text/csv" required onchange="this.form.submit()">
        </form>
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

    @if ($errors->has('file'))
        <div class="alert alert--error" role="alert">{{ $errors->first('file') }}</div>
    @endif

    <form class="search-form" method="GET" action="{{ route('participants.index') }}" role="search">
        <label class="visually-hidden" for="participant-search">Rechercher un participant</label>
        <input class="input" id="participant-search" name="q" type="search" value="{{ $search }}" placeholder="Rechercher un participant...">
        <button class="btn btn--primary" type="submit">Rechercher</button>
        @if ($search !== '')
            <a class="btn" href="{{ route('participants.index') }}">Effacer</a>
        @endif
    </form>

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
