<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUser', 'status', 'prixTotal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function detailsCommandes()
    {
        return $this->hasMany(DetailCommande::class);
    }

    public function payements()
    {
        return $this->hasMany(Payement::class);
    }

    public function factures()
    {
        return $this->hasOne(Facture::class);
    }
    // Commande.php
public function livres()
{
    return $this->belongsToMany(Livre::class, 'commande_livre')->withPivot('quantite');
}
}
