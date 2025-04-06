<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'auteur', 'idcategorie', 'prix', 'image', 'stock',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'idCategorie');
    }

    public function detailsCommandes()
    {
        return $this->hasMany(DetailCommande::class);
    }
    public function commandes()
    {
    return $this->belongsToMany(Commande::class, 'commande_livre')->withPivot('quantite');
    }
}
