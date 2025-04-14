<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
  /*  public function index()
{
    $commande_total = \App\Models\Commande::count();
    $commande_valide = \App\Models\Commande::where('status', 'payée')->count();
    $revenue_jour = \App\Models\Commande::whereDate('created_at', now()->toDateString())->sum('prixTotal');
    $total_ventes = \App\Models\Commande::sum('prixTotal');

    $commande_mensuelle = \App\Models\Commande::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mois, COUNT(*) as total")
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total', 'mois');

    $vente_mensuel = \App\Models\Commande::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mois, SUM(prixTotal) as total")
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total', 'mois');

    return view('statistiques.index', compact(
        'commande_total',
        'commande_valide',
        'revenue_jour',
        'total_ventes',
        'commande_mensuelle',
        'vente_mensuel'
    ));
}*/
public function index()
{
    // Total des commandes
    $totalCommandes = Commande::count();

    // Total des commandes validées (par exemple statut = "payée")
    $commande_valide = Commande::where('status', 'payée')->count();

    // Total des ventes (attention à bien mettre "prixTotal" entre guillemets)
    $commande_total = Commande::sum('prixTotal');

    // Revenus d'aujourd'hui
    $revenue_jour = Commande::whereDate('created_at', today())->sum('prixTotal');

    // Commandes par mois (nombre de commandes)
    $commande_mensuelle = Commande::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mois, COUNT(*) as total")
                                ->groupBy('mois')
                                ->orderBy('mois')
                                ->pluck('total', 'mois');

    // Ventes par mois (somme des prix)
    $vente_mensuel = Commande::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mois, SUM(\"prixTotal\") as total")
                            ->groupBy('mois')
                            ->orderBy('mois')
                            ->pluck('total', 'mois');

    return view('statistiques.index', compact(
        'totalCommandes',
        'commande_total',
        'commande_valide',
        'revenue_jour',
        'commande_mensuelle',
        'vente_mensuel'
    ));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
