@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">📚 Liste des catégories de livres</h1>

    @if($categories->count())
        <div class="table-responsive">
            <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Ajouter une catégorie</a>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom de la catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->nom }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Modifier Button -->
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                                        ✏️ Modifier
                                    </a>
                                    
                                    <!-- Supprimer Button -->
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
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
            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p class="text-center text-muted">Aucune catégorie trouvée.</p>
    @endif
</div>
@endsection
