<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
    ];

    /*public function livres()
    {
        return $this->hasMany(Livre::class);
    }*/
    // Dans le modèle Category
   public function livres()
   {
    return $this->hasMany(Livre::class, 'idCategorie'); // Utilisez 'idCategorie' au lieu de 'categorie_id'
   }
}
