<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'numero_commande',
        'visiteur_id',
        'chocolat_id',
        'allergie',
        'date_commande_debut',
        'date_commande_fin',
        'statut',
    ];

    protected $casts = [
        'date_commande_debut' => 'datetime',
        'date_commande_fin' => 'datetime',
    ];

    public function visiteur()
    {
        return $this->belongsTo(Visiteur::class, 'visiteur_id');
    }

    public function chocolat()
    {
        return $this->belongsTo(Chocolat::class, 'chocolat_id');
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'commande_id');
    }
}
