@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">📦 Mes Commandes</h2>

    <div class="text-end mb-3">
        <a href="{{ route('commandes.create') }}" class="btn btn-success">
            ➕ Nouvelle commande
        </a>
    </div>

    @if($commandes->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Livres commandés</th>
                        <th>Total</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td class="text-center">{{ $commande->id }}</td>
                            <td class="text-center">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @php
                                    $badgeClass = match($commande->status) {
                                        'en_attente' => 'warning',
                                        'en_preparation' => 'info',
                                        'expediee' => 'primary',
                                        'payee' => 'success',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ strtoupper(str_replace('_', ' ', $commande->status)) }}
                                </span>
                            </td>
                            <td>
                                <ul class="mb-0">
                                    @foreach($commande->livres as $livre)
                                        <li>
                                            <strong>{{ $livre->titre }}</strong>
                                            (x{{ $livre->pivot->quantite }}) —
                                            {{ number_format($livre->prix, 0, ',', ' ') }} FCFA
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-end">
                                {{ number_format($commande->prixTotal, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-center">
                                @php
                                    $dejaPaye = \App\Models\Payement::where('commandeId', $commande->id)->exists();
                                @endphp

                                @if($commande->status === 'payée' && !$dejaPaye)
                                    <form action="{{ route('paiement.effectuer', $commande->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            💰 Payer
                                        </button>
                                    </form>
                                @elseif($commande->status === 'payée' && $dejaPaye)
                                    <span class="badge bg-success">Déjà payée</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-between">
            <div>
                <p class="mb-0">Page {{ $commandes->currentPage() }} sur {{ $commandes->lastPage() }}</p>
            </div>
            <div>
                {{ $commandes->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            🛒 Aucune commande passée pour le moment.
        </div>
    @endif
</div>
@endsection
