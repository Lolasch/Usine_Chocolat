<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chocolat extends Model
{
    use HasFactory;

    protected $table = 'chocolats';

    protected $fillable = [
        'nom',
        'description',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'chocolat_id');
    }
}
