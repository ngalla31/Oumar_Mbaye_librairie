<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatutCommandeMail;
use Illuminate\Http\Request;
use App\Notifications\NouvelleCommandeNotification;
use App\Models\User;
use App\Models\Commande;
use App\Models\Livre;
use App\Models\Notification; 
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::where('idUser', auth()->id())
        ->with('livres')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('client.commande', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livres = Livre::where('stock', '>', 0)->get(); // seulement les livres disponibles
        return view('client.creerCommande', compact('livres'));
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // 1. Validation rapide
    $request->validate([
        'livres' => 'required|array',
        'quantites' => 'required|array',
    ]);

    // 2. Initialisation des variables
    $userId = auth()->id();
    $total = 0;

    // 3. Création de la commande
    $commande = new Commande();
    $commande->idUser = $userId;
    $commande->status = 'en_attente'; // statut initial
    $commande->prixTotal = 0; // on met à jour plus bas
    $commande->save();

    // 4. Association des livres
    foreach ($request->livres as $index => $livreId) {
        $livre = Livre::find($livreId);
        $quantite = $request->quantites[$index];

        // Vérifie que le stock est suffisant
        if ($livre && $livre->stock >= $quantite) {
            // Ajout dans la table pivot (commande_livre)
            $commande->livres()->attach($livreId, ['quantite' => $quantite]);

            // Mettre à jour le stock du livre
            $livre->stock -= $quantite;
            $livre->save();

            // Calcul du total
            $total += $livre->prix * $quantite;
        }
    }

    // 5. Mise à jour du prix total
    $commande->prixTotal = $total;
    $commande->save();
    // 6. Notification au(x) gestionnaire(s)
    $gestionnaires = User::where('role', 'gestionnaire')->get();

      foreach ($gestionnaires as $gestionnaire) {
    $gestionnaire->notify(new NouvelleCommandeNotification($commande));
    }
     // Enregistrement de la notification dans la table notifications
     DB::table('notifications')->insert([
        'userId' => $gestionnaire->id,
        'message' => "Nouvelle commande n°{$commande->id} en attente. Montant: " . number_format($commande->prixTotal, 0, ',', ' ') . " FCFA",
       'dateLecture' => null, // Si la valeur peut être nulle au départ
        //'created_at' => now(),
        //'updated_at' => now(),
        'created_at' => now()->toDateTimeString(),  // format Y-m-d H:i:s
        'updated_at' => now()->toDateTimeString(),
    ]);

    // 7. Redirection avec message
    return redirect()->route('commandes.client')->with('success', 'Commande enregistrée avec succès.');
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
    /*public function getCommandeForGestionnaire(){
        $commandes = Commande::where('status', 'en_attente')->get();
        return view('gestionnaire.commande', compact('commandes'));
    }*/
    public function getCommandeForGestionnaire()
    {
   /* $commandes = Commande::where('status', 'en_attente')
        ->with('user') // chargement de la relation
        ->get();*/
        $commandes = Commande::with('user')->get(); // pas de where
        return view('gestionnaire.commande', compact('commandes'));    

    return view('gestionnaire.commande', compact('commandes'));
    }

    public function traiter(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $statut = ''; 
        if ($request->action === 'valider') {
            $commande->status = 'payée';
        } elseif ($request->action === 'refuser') {
            $commande->status = 'annulée';
        }

        $commande->save();
        // Envoi du mail à l'utilisateur
        //Mail::to($commande->user->email)->send(new StatutCommandeMail($commande));
        // Envoi du mail
       Mail::to($commande->user->email)->send(new StatutCommandeMail($commande, $statut));
        // Ajout de la notification dans la table notifications
        Notification::create([
        'userId' => $commande->user->id,
        'message' => 'Votre commande numero' . $commande->id . ' a été ' . $statut . '.',
        'dateLecture' => null, // NULL signifie que la notification n'a pas été lue
       ]);
        return redirect()->route('commande.gestionnaire')->with('success', 'Commande mise à jour.');
    }
}
