@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5 text-primary">✏️ Ajouter un nouvel utilisateur</h1>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="nom" class="form-label fw-bold">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="prenom" class="form-label fw-bold">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-bold">Rôle</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">Ajouter l'utilisateur</button>
                    <a href="{{ route('utilisateurs') }}" class="btn btn-secondary px-4 py-2">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
