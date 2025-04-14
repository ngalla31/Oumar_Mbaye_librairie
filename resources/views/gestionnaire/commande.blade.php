@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Commandes à valider</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet du client</th>
                <th>Prix Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>

                    {{-- Affiche le nom complet ou "Inconnu" si user est null --}}
                    <td>
                        @if($commande->user)
                            {{ $commande->user->prenom }} {{ $commande->user->nom }}
                        @else
                            Inconnu
                        @endif
                    </td>

                    {{-- Prix formaté --}}
                    <td>{{ number_format($commande->prixTotal, 2, ',', ' ') }} Frs CFA</td>

                    {{-- Affichage stylisé du statut --}}
                    <td>
                        @if($commande->status === 'en_attente')
                            <span class="badge bg-warning text-dark">En attente</span>
                        @elseif($commande->status === 'payée')
                            <span class="badge bg-success">Validée</span>
                        @elseif($commande->status === 'annulée')
                            <span class="badge bg-danger">Refusée</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($commande->status) }}</span>
                        @endif
                    </td>

                    {{-- Boutons d'action --}}
                    <td>
                        <form action="{{ route('commandes.traiter', $commande->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" name="action" value="valider" class="btn btn-success btn-sm me-2">
                                Valider
                            </button>
                            <button type="submit" name="action" value="refuser" class="btn btn-danger btn-sm">
                                Refuser
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
