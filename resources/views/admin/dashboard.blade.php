@extends('template')

@section('titre', 'Administration — Educia BDE')

@section('surtitre', 'Administration — Educia BDE')

@section('actions')
    <a class="btn" href="{{ route('index') }}">Retour au site</a>
    <a class="btn btn--primary" href="{{ route('events.create') }}">Nouvel événement</a>
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
            <a class="card__link" href="{{ route('participants.index') }}">Gérer les participants →</a>
        </article>

    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif

    @if ($errors->has('user'))
        <div class="alert alert--error" role="alert">{{ $errors->first('user') }}</div>
    @endif

    <section class="admin-users" aria-labelledby="admin-users-title">
        <div class="section-heading">
            <h2 class="section-title" id="admin-users-title">Comptes du BDE</h2>
            <span class="form-help">{{ $users->count() }} compte(s)</span>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th><span class="visually-hidden">Actions</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form class="user-role-form" action="{{ route('admin.users.role', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select class="input" name="role" aria-label="Rôle de {{ $user->name }}">
                                        <option value="user" @selected($user->role === 'user')>Utilisateur</option>
                                        <option value="admin" @selected($user->role === 'admin')>Administrateur</option>
                                    </select>
                                    <button class="btn btn--primary" type="submit">Enregistrer</button>
                                </form>
                            </td>
                            <td class="table__actions">
                                @if ($user->is(auth()->user()))
                                    <span class="form-help">Compte actuel</span>
                                @else
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-btn text-btn--danger" type="submit" onclick="return confirm('Supprimer ce compte ?')">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucun compte utilisateur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
