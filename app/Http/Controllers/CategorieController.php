<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Récupérer toutes les catégories, paginées
         $categories = Categorie::paginate(5);
         return view('gestionnaire.categorie', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gestionnaire.categorieCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // Validation des données du formulaire
      $validatedData = $request->validate([
        'nom' => 'required|string|max:255|unique:categories,nom',
    ]);

    // Créer et enregistrer la nouvelle catégorie
    Categorie::create([
        'nom' => $validatedData['nom'],
    ]);

    // Rediriger vers la page des catégories avec un message de succès
    return redirect()->route('categories')->with('success', 'Catégorie ajoutée avec succès!');   
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
        $category = Categorie::findOrFail($id);
        return view('gestionnaire.editCat', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $id,
        ]);

        // Trouver la catégorie à mettre à jour
        $category = Categorie::findOrFail($id);

        // Mettre à jour la catégorie avec les nouvelles données
        $category->nom = $validatedData['nom'];
        $category->save();

        // Rediriger avec un message de succès
        return redirect()->route('categories')->with('success', 'Catégorie mise à jour avec succès!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->route('categories')->with('success', 'Catégorie supprimée avec succès!');
    }
}
