<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivresController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\NotificationController;
use App\Models\Facture;
use App\Models\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//Route pour le gestionnaire
Route::get('/livres',[LivresController::class, 'index'])->name('livres');
Route::get('/categories',[CategorieController::class, 'index'])->name('categories');
Route::get('/commandes',[CommandeController::class, 'index'])->name('commandes');
Route::get('/statitisques',[StatistiquesController::class,'index'])->name('statistiques');
//lister les utilisateurs
Route::get('/utilisateurs',[UtilisateursController::class, 'index'])->name('utilisateurs');
// Créer un utilisateur
Route::get('/create',[UtilisateursController::class, 'create'])->name('gestionnaire.create');
// Enregistrer un utilisateur
Route::post('/users/store',[UtilisateursController::class, 'store'])->name('users.store');
// Supprimer un utilisateur
Route::delete('users/{id}',[UtilisateursController::class, 'destroy'])->name('destroy.user');
// Modifier un utilisateur
Route::get('users/{id}/edit',[UtilisateursController::class, 'edit'])->name('users.edit');
// Confimer la mise a jour dans la base
Route::put('users/{id}',[UtilisateursController::class, 'update'])->name('users.update');
//lister les categories
Route::get('categorie',[UtilisateursController::class, 'index'])->name('categorie');
// Créer une catégorie
Route::get('categories/create', [CategorieController::class, 'create'])->name('categories.create');
// Enregistrer une catégorie
Route::post('categories/store', [CategorieController::class, 'store'])->name('categories.store');
// Modifier une catégorie
Route::get('categories/{id}/edit', [CategorieController::class, 'edit'])->name('categories.edit');
// Afficher le formulaire de modification de la catégorie
Route::get('categories/{id}/edit', [CategorieController::class, 'edit'])->name('categories.edit');

// Mettre à jour une catégorie
Route::put('categories/{id}', [CategorieController::class, 'update'])->name('categories.update');

// Supprimer une catégorie
Route::delete('categories/{id}', [CategorieController::class, 'destroy'])->name('categories.destroy');
//creation d'un livre
Route::get('livres/create', [LivresController::class, 'create'])->name('livres.create');
//enregistrer un livre dans la base
Route::post('livres', [LivresController::class, 'store'])->name('livres.store');
//pour supprimer un livre
Route::delete('livres/{id}',[LivresController::class, 'destroy'])->name('livres.destroy');
//editer un livre
Route::get('livres/{id}/edit', [LivresController::class, 'edit'])->name('livres.edit');
//modifier un livre dans la base
Route::put('livres/{id}',[LivresController::class, 'update'])->name('livres.update');
//Route pour la vue d'un client sur les livres
//Route::get('livres/client',[LivresController::class, 'vueClent'])->name('livres.client');
//Route pour le client
//Route pour voir tous les livres
Route::get('/livres/client',[LivresController::class, 'vueClient'])->name('livres.client');
//Route pour trier la vue sur les livres
Route::get('/livres/trie',[LivresController::class, 'trie'])->name('livres.trie');
//Route pour voir mes commande
Route::get('/commandes/client',[CommandeController::class, 'index'])->name('commandes.client');
//Route pour faire une commande
Route::post('/commandes/store',[CommandeController::class, 'store'])->name('commandes.stores');
//Route pour enregistrer une commande
Route::get('/commandes/create',[CommandeController::class, 'create'])->name('commandes.create');
Route::get('/factures',[FactureController::class, 'index'])->name('factures.client');
Route::get('/notifications/client',[NotificationController::class, 'index'])->name('notifications.client');
require __DIR__.'/auth.php';
