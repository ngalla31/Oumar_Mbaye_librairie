<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UtilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les utilisateurs
          //$users = User::all();
          $users = User::paginate(6);
        // Retourner la vue avec les utilisateurs
         return view('gestionnaire.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gestionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données envoyées par le formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' signifie qu'un champ 'password_confirmation' est requis dans le formulaire
            'role' => 'required|in:gestionnaire,client', // Validation du rôle
        ]);

        // Création de l'utilisateur dans la base de données
        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hashage du mot de passe avant de l'enregistrer
            'role' => $validatedData['role'],
        ]);

        // Redirection après la création de l'utilisateur
        return redirect()->route('utilisateurs')->with('success', 'Utilisateur créé avec succès!');
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
         // Trouver l'utilisateur avec l'ID
         $user = User::findOrFail($id);

        // Retourner la vue avec l'utilisateur
       return view('gestionnaire.edit', compact('user'));  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all()); // Cela vous montrera toutes les données envoyées dans la requête

         // Valider les données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:gestionnaire,client',
        //'password' => 'nullable|confirmed|min:8', // Le mot de passe est facultatif, mais s'il est fourni, il doit être confirmé et avoir une longueur minimale
        
    ]);

    // Trouver l'utilisateur par ID
    $user = User::findOrFail($id);

    // Mettre à jour les informations de l'utilisateur
    $user->nom = $validatedData['nom'];
    $user->prenom = $validatedData['prenom'];
    $user->email = $validatedData['email'];
    $user->role = $validatedData['role'];

    // Si un mot de passe a été fourni, on le hache et on le met à jour
    if ($request->filled('password')) {
        $user->password = bcrypt($validatedData['password']);
    }

    // Sauvegarder les changements
    $user->save();

    // Rediriger avec un message de succès
    return redirect()->route('utilisateurs')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Supprimer l'utilisateur
    $user->delete();

    // Rediriger l'utilisateur vers la page de la liste avec un message de succès
    return redirect()->route('utilisateurs')->with('success', 'Utilisateur supprimé avec succès!');

    }
}
