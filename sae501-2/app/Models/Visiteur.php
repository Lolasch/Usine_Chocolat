<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    use HasFactory;

    protected $table = 'visiteurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'visiteur_id');
    }
}
