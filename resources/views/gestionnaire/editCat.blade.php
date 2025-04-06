@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">🖊️ Modifier la catégorie</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Formulaire pour la mise à jour de la catégorie -->
            <form method="POST" action="{{ route('categories.update', $category->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la catégorie</label>
                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $category->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Mettre à jour la catégorie</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
