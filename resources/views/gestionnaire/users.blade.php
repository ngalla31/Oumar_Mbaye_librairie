@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">👥 Liste des utilisateurs</h1>

    @if($users->count())
        <div class="table-responsive">
            <a href="{{ route('gestionnaire.create') }} " class="btn btn-success">Ajouter un utilisateur</a>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nom }}</td>
                            <td>{{ $user->prenom }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'gestionnaire' ? 'bg-success' : 'bg-primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <!-- Modifier Button -->
                                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-warning btn-sm me-2">
                                        ✏️ Modifier
                                    </a>
                                    
                                    <!-- Supprimer Button -->
                                    <form action="{{ route('destroy.user',$user->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p class="text-center text-muted">Aucun utilisateur trouvé.</p>
    @endif
</div>
@endsection
