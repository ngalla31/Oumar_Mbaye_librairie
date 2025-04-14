<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $commande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 15px;
            background-color: #f8f9fa;
        }
        .invoice-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .header-title {
            font-size: 26px;
            font-weight: bold;
            color: #343a40;
        }
        .info-label {
            color: #6c757d;
        }
        .total-row th {
            background-color: #e9ecef;
            font-size: 16px;
        }
        .btn-download {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="invoice-box mx-auto col-md-10 col-lg-8">
        <h2 class="text-center mb-4 header-title">🧾 Facture de Commande</h2>

        <div class="mb-4">
            <div><span class="info-label">Numéro de commande :</span> <strong>#{{ $commande->id }}</strong></div>
            <div><span class="info-label">Date :</span> <strong>{{ $commande->created_at->format('d/m/Y H:i') }}</strong></div>
            <div><span class="info-label">Client :</span> <strong>{{ $commande->user->prenom . ' ' . $commande->user->nom ?? 'Client' }}</strong></div>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Livre</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-end">Prix unitaire</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->livres as $livre)
                    <tr>
                        <td>{{ $livre->titre }}</td>
                        <td class="text-center">{{ $livre->pivot->quantite }}</td>
                        <td class="text-end">{{ number_format($livre->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="text-end">{{ number_format($livre->prix * $livre->pivot->quantite, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="3" class="text-end">Total à payer :</th>
                    <th class="text-end">{{ number_format($commande->prixTotal, 0, ',', ' ') }} FCFA</th>
                </tr>
            </tfoot>
        </table>

        <p class="mt-4 text-center"><em>Merci pour votre commande ! 📚</em></p>

        @if(!app()->runningInConsole())
        <div class="text-center mt-4">
            <a href="{{ asset('factures/facture_' . $commande->id . '.pdf') }}" class="btn btn-outline-primary btn-download" download>
                📄 Télécharger la facture
            </a>
        </div>
        @endif
    </div>
</div>
</body>
</html>
