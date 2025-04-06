@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Passer une commande</h2>

    <form action="{{ route('commandes.stores') }}" method="POST">
        @csrf

        <div class="row">
            @foreach($livres as $livre)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="livres[]" value="{{ $livre->id }}" id="livre-{{ $livre->id }}">
                                <label class="form-check-label" for="livre-{{ $livre->id }}">
                                    <strong>{{ $livre->titre }}</strong> — {{ $livre->prix }} Frs CFA
                                </label>
                            </div>

                            <div class="mb-2">
                                <label for="quantite-{{ $livre->id }}" class="form-label">Quantité :</label>
                                <input type="number" class="form-control" name="quantites[]" id="quantite-{{ $livre->id }}" min="1" max="{{ $livre->stock }}" value="1">
                            </div>

                            <p class="text-muted mb-0">Stock disponible : {{ $livre->stock }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4">Commander</button>
            <a href="{{ route('commandes.client') }}" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>
@endsection
