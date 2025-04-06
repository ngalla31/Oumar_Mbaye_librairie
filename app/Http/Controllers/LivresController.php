<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Livre;
use Illuminate\Support\Facades\Storage;
class LivresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les livres avec leur catégorie associée
        //$livres = Livre::with('categorie')->get();

        // Passer les livres à la vue
        //return view('gestionnaire.livres', compact('livres'));
        // Paginer les livres, par exemple, 10 livres par page
         $livres = Livre::paginate(10);

       // Passer les livres à la vue
       return view('gestionnaire.livres', compact('livres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  
        $categories = Categorie::all();
        return view('gestionnaire.livreCreate', compact('categories'));
        //return view('gestionnaire.livreCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'prix' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour l'image
        'stock' => 'required|integer|min:0',
        'idCategorie' => 'required|exists:categories,id', // Validation de la catégorie
    ]);

    // Si une image a été téléchargée
    if ($request->hasFile('image')) {
        // Enregistrez l'image dans le dossier public
        $imagePath = $request->file('image')->store('livres/images', 'public');
    } else {
        // Si aucune image n'est téléchargée, une valeur par défaut peut être utilisée
        $imagePath = 'default-image.jpg'; // Mettre une image par défaut ou laisser vide selon le cas
    }

    // Créer une nouvelle instance du modèle Livre
    $livre = new Livre();
    $livre->titre = $validatedData['titre'];
    $livre->auteur = $validatedData['auteur'];
    $livre->prix = $validatedData['prix'];
    $livre->image = $imagePath; // Sauvegarder le chemin de l'image
    $livre->stock = $validatedData['stock'];
    $livre->idCategorie = $validatedData['idCategorie'];

    // Sauvegarder le livre dans la base de données
    $livre->save();

    // Redirection après enregistrement avec un message de succès
    return redirect()->route('livres')->with('success', 'Le livre a été ajouté avec succès.');
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
        $livre = Livre::findOrFail($id);
        $categories = Categorie::all(); // ou comme tu appelles ta table
    
        return view('gestionnaire.livreEdit', compact('livre', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
               // Validation des données du formulaire
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'prix' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'stock' => 'required|integer|min:0',
        'idCategorie' => 'required|exists:categories,id',
    ]);

    // Trouver le livre par ID
    $livre = Livre::findOrFail($id);

    // Si une nouvelle image a été téléchargée
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image si elle existe
        if ($livre->image && Storage::exists($livre->image)) {
            Storage::delete($livre->image);
        }

        // Enregistrer la nouvelle image
        $imagePath = $request->file('image')->store('public/livres');
    } else {
        // Garder l'ancienne image si aucune nouvelle image n'est fournie
        $imagePath = $livre->image;
    }

    // Mettre à jour les informations du livre
    $livre->update([
        'titre' => $validatedData['titre'],
        'auteur' => $validatedData['auteur'],
        'prix' => $validatedData['prix'],
        'image' => $imagePath,
        'stock' => $validatedData['stock'],
        'idCategorie' => $validatedData['idCategorie'],
    ]);
    $livre->titre = $request->titre;
    $livre->auteur = $request->auteur;
    $livre->prix = $request->prix;
    $livre->stock = $request->stock;
    $livre->idCategorie = $request->idCategorie;

    $livre->save();

    // Rediriger avec un message de succès
    return redirect()->route('livres')->with('success', 'Livre mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            // Trouver le livre par son ID
    $livre = Livre::findOrFail($id);

    // Supprimer l'image si elle existe
    if ($livre->image && Storage::exists($livre->image)) {
        Storage::delete($livre->image);
    }

    // Supprimer le livre de la base de données
    $livre->delete();

    // Rediriger avec un message de succès
    return redirect()->route('livres')->with('success', 'Livre supprimé avec succès!');
    }
    //fonction pour voir l'ensemble des livres
    function vueClient(){
        $livres = Livre::with('categorie')->paginate(10); // on charge la relation "categorie"
        return view('client.catalogue', compact('livres'));
    }
    //fonction pour trier la vue
    public function trie(Request $request)
     {
    $search = $request->input('search');

    $livres = Livre::with('categorie')
        ->when($search, function ($query, $search) {
            $query->where('titre', 'like', "%{$search}%")
                  ->orWhere('auteur', 'like', "%{$search}%")
                  ->orWhere('prix', 'like', "%{$search}%");
        })
        ->paginate(10);

    return view('client.catalogueTrie', compact('livres'));
  }


}
