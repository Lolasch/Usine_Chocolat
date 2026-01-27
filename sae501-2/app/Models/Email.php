<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $table = 'emails';

    protected $fillable = [
        'commande_id',
        'type',
        'date_envoi',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
