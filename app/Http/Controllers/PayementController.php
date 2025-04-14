<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Payement;
use App\Models\Facture;
use Illuminate\Support\Facades\Auth;


class PayementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    /*public function effectuer($commandeId)
    {
        //dd($commandeId);

        $commande = Commande::findOrFail($commandeId);

        // Vérifie si la commande appartient à l'utilisateur connecté
        if ($commande->idUser !== Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas payer cette commande.');
        }

        // Vérifie que la commande est bien validée
        if ($commande->status !== 'payée') {
            return back()->with('error', 'Cette commande n’est pas encore prête pour le paiement.');
        }

        // Vérifie si le paiement existe déjà
        if (Payement::where('commandeId', $commande->id)->exists()) {
            return back()->with('error', 'Le paiement a déjà été effectué.');
        }

        // Enregistre le paiement
        Payement::create([
            'commandeId' => $commande->id,
            'montant' => $commande->prixTotal,
            'date' => now(),
        ]);

        return back()->with('success', 'Paiement effectué avec succès !');
    }*/
    public function effectuer($commandeId)
{
    // Récupère la commande avec ses livres
    $commande = Commande::with('livres', 'user')->findOrFail($commandeId);

    // Vérifie si la commande appartient à l'utilisateur connecté
    if ($commande->idUser !== Auth::id()) {
        return back()->with('error', 'Vous ne pouvez pas payer cette commande.');
    }

    // Vérifie que la commande est bien validée pour le paiement
    if ($commande->status !== 'payée') {
        return back()->with('error', 'Cette commande n’est pas encore prête pour le paiement.');
    }

    // Vérifie si le paiement existe déjà
    if (Payement::where('commandeId', $commande->id)->exists()) {
        return back()->with('error', 'Le paiement a déjà été effectué.');
    }

    // Enregistre le paiement
    Payement::create([
        'commandeId' => $commande->id,
        'montant' => $commande->prixTotal,
        'date' => now(),
    ]);

    // Générer la facture PDF
    $pdf = Pdf::loadView('facture', compact('commande'));

    // Créer un nom unique pour le fichier PDF
    $fileName = 'facture_' . $commande->id . '_' . time() . '.pdf';

    // Définir le chemin du fichier PDF dans le dossier 'public/factures/'
    $pdfPath = public_path('factures/' . $fileName);

    // Enregistrer le PDF sur le serveur
    $pdf->save($pdfPath);

    // Enregistrer la référence de la facture dans la base de données
    Facture::create([
        'commandeId' => $commande->id,  // ID de la commande associée
        'pdfPath' => 'factures/' . $fileName,  // Chemin relatif du PDF
    ]);

    // Met à jour le statut de la commande pour "payée"
    $commande->status = 'payée';
    $commande->save();

    // Redirige l'utilisateur avec un message de succès
    return back()->with('success', 'Paiement effectué et facture générée avec succès !');
}

}
