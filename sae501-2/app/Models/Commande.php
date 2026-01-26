<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commande
 * 
 * @property int $id
 * @property string $numero_commande
 * @property int $visiteur_id
 * @property int $chocolat_id
 * @property string|null $allergie
 * @property Carbon $date_commande_debut
 * @property Carbon|null $date_commande_fin
 * @property string $statut
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Chocolat $chocolat
 * @property Visiteur $visiteur
 * @property Collection|Poste[] $postes
 * @property Collection|ConsommationsStock[] $consommations_stocks
 * @property Collection|Email[] $emails
 * @property Collection|NonConformite[] $non_conformites
 *
 * @package App\Models
 */
class Commande extends Model
{
	protected $table = 'commandes';

	protected $casts = [
		'visiteur_id' => 'int',
		'chocolat_id' => 'int',
		'date_commande_debut' => 'datetime',
		'date_commande_fin' => 'datetime'
	];

	protected $fillable = [
		'numero_commande',
		'visiteur_id',
		'chocolat_id',
		'allergie',
		'date_commande_debut',
		'date_commande_fin',
		'statut'
	];

	public function chocolat()
	{
		return $this->belongsTo(Chocolat::class);
	}

	public function visiteur()
	{
		return $this->belongsTo(Visiteur::class);
	}

	public function postes()
	{
		return $this->belongsToMany(Poste::class, 'commandes_postes')
					->withPivot('id', 'date_entree', 'date_sortie', 'conforme')
					->withTimestamps();
	}

	public function consommations_stocks()
	{
		return $this->hasMany(ConsommationsStock::class);
	}

	public function emails()
	{
		return $this->hasMany(Email::class);
	}

	public function non_conformites()
	{
		return $this->hasMany(NonConformite::class);
	}
}
