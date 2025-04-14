@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">📊 Statistiques des Commandes</h2>

    <!-- Total des commandes et total des ventes -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total des commandes :</h5>
                <h3>{{ $totalCommandes }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total des commandes validées :</h5>
                <h3>{{ $commande_valide }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total des ventes :</h5>
                <h3>{{ number_format($commande_total, 0, ',', ' ') }} FCFA</h3>
            </div>
        </div>
    </div>

    <!-- Revenus d'aujourd'hui -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm p-3">
                <h5>Revenus d'aujourd'hui :</h5>
                <h3>{{ number_format($revenue_jour, 0, ',', ' ') }} FCFA</h3>
            </div>
        </div>
    </div>

    <!-- Commandes par mois (graphique) -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="mb-3">Commandes par mois :</h5>
        <canvas id="chartCommandes" height="100"></canvas>
    </div>

    <!-- Ventes par mois (graphique) -->
    <div class="card shadow-sm p-4">
        <h5 class="mb-3">Ventes par mois :</h5>
        <canvas id="chartVentes" height="100"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Commandes par mois
    const commandesCtx = document.getElementById('chartCommandes').getContext('2d');
    const commandesChart = new Chart(commandesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($commande_mensuelle->toArray())) !!},
            datasets: [{
                label: 'Commandes',
                backgroundColor: '#0d6efd',
                data: {!! json_encode(array_values($commande_mensuelle->toArray())) !!}
            }]
        }
    });

    // Ventes par mois
    const ventesCtx = document.getElementById('chartVentes').getContext('2d');
    const ventesChart = new Chart(ventesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($vente_mensuel->toArray())) !!},
            datasets: [{
                label: 'Ventes (FCFA)',
                backgroundColor: '#28a745',
                data: {!! json_encode(array_values($vente_mensuel->toArray())) !!}
            }]
        }
    });
</script>
@endsection
