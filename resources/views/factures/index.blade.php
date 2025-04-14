@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">📁 Mes Factures</h2>

    @if($factures->count())
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Date commande</th>
                    <th>Total</th>
                    <th>Facture</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                    <tr>
                        <td class="text-center">{{ $facture->id }}</td>
                        <td class="text-center">{{ $facture->commande->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            {{ number_format($facture->commande->prixTotal, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="text-center">
                            <a href="{{ asset($facture->pdfPath) }}" class="btn btn-sm btn-outline-primary" download>
                                📄 Télécharger
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info text-center">
            Aucune facture disponible pour le moment.
        </div>
    @endif
</div>
@endsection
