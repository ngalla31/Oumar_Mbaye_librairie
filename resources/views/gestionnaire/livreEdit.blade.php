@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">✏️ Modifier le livre</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('livres.update', $livre->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du livre</label>
                    <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror"
                        value="{{ old('titre', $livre->titre) }}" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Auteur -->
                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" name="auteur" id="auteur" class="form-control @error('auteur') is-invalid @enderror"
                        value="{{ old('auteur', $livre->auteur) }}" required>
                    @error('auteur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix (€)</label>
                    <input type="number" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror"
                        value="{{ old('prix', $livre->prix) }}" step="0.01" required>
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label">Image actuelle</label><br>
                    @if($livre->image)
                        <img src="{{ asset('storage/' . $livre->image) }}" alt="Image du livre" class="img-thumbnail mb-2" style="max-height: 150px;">
                    @else
                        <p>Aucune image</p>
                    @endif

                    <label for="image" class="form-label d-block">Changer l'image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock', $livre->stock) }}" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-3">
                    <label for="idCategorie" class="form-label">Catégorie</label>
                    <select name="idCategorie" id="idCategorie" class="form-select @error('idCategorie') is-invalid @enderror" required>
                        <option value="" disabled>Choisir une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('idCategorie', $livre->idCategorie) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idCategorie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
                    <a href="{{ route('livres') }}" class="btn btn-secondary ms-2">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
