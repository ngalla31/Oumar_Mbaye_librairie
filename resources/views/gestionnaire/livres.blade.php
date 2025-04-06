@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">📚 Liste des livres</h1>

    @if($livres->count())
        <div class="table-responsive">
            <a href="{{ route('livres.create') }}" class="btn btn-success mb-3">Ajouter un livre</a>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th> <!-- Nouvelle colonne pour afficher l'image -->
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($livres as $livre)
                        <tr>
                            <td>
                                @if($livre->image)
                                    <img src="{{ asset('storage/' . $livre->image) }}" alt="Image du livre" class="img-thumbnail shadow-sm" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>{{ $livre->id }}</td>
                            <td>{{ $livre->titre }}</td>
                            <td>{{ $livre->auteur }}</td>
                            <td>{{ number_format($livre->prix, 2, ',', ' ') }} Frs CFA</td>
                            <td>{{ $livre->stock }}</td>
                            <td>
                                @if($livre->categorie)
                                    {{ $livre->categorie->nom }}
                                @else
                                    <span class="text-muted">Aucune catégorie</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <!-- Modifier Button -->
                                    <a href="{{ route('livres.edit', $livre->id) }}" class="btn btn-warning btn-sm me-2">
                                        ✏️ Modifier
                                    </a>
                                    
                                    <!-- Supprimer Button -->
                                    <form action="{{ route('livres.destroy', $livre->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
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
            {{ $livres->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p class="text-center text-muted">Aucun livre trouvé.</p>
    @endif
</div>
@endsection
