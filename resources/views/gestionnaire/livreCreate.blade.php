@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">📚 Ajouter un nouveau livre</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('livres.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du livre</label>
                    <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Auteur -->
                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" name="auteur" id="auteur" class="form-control @error('auteur') is-invalid @enderror" value="{{ old('auteur') }}" required>
                    @error('auteur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix (€)</label>
                    <input type="number" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix') }}" step="0.01" required>
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image du livre</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Catégorie</label>
                    <select name="idCategorie" id="idCategorie" class="form-select @error('categorie_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Choisir une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('idCategorie') == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                    @error('idCategorie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Ajouter le livre</button>
                    <a href="{{ route('livres') }}" class="btn btn-secondary ms-2">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
