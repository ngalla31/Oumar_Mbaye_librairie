@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">📚 Liste des livres disponibles</h1>
   <!-- Formulaire de recherche -->
<form method="GET" action="{{ route('livres.trie') }}" class="mb-4 d-flex justify-content-center">
    <input 
        type="text" 
        name="search" 
        class="form-control w-50 me-2" 
        placeholder="Rechercher un livre par titre ou auteur..." 
        value="{{ request('search') }}"
    >
    <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
</form>

    @if($livres->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
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
