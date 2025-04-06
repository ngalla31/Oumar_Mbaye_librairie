<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCommande extends Model
{
    use HasFactory;
    protected $fillable = [
        'commandeId', 'livreId', 'quantity', 'montant',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commandeId');
    }

    public function livre()
    {
        return $this->belongsTo(Livre::class, 'livreId');
    }
}
