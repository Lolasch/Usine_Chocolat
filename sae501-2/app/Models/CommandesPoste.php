<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommandesPoste
 *
 * @property int $id
 * @property int $commande_id
 * @property int $poste_id
 * @property Carbon|null $date_entree
 * @property Carbon|null $date_sortie
 * @property bool|null $conforme
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Commande $commande
 * @property Poste $poste
 *
 * @package App\Models
 */
class CommandesPoste extends Model
{
	protected $table = 'commandes_postes';

	protected $casts = [
		'commande_id' => 'int',
		'poste_id' => 'int',
		'date_entree' => 'datetime',
		'date_sortie' => 'datetime',
		'conforme' => 'bool'
	];

	protected $fillable = [
		'commande_id',
		'poste_id',
		'date_entree',
		'date_sortie',
		'conforme'
	];

	public function commande()
	{
		return $this->belongsTo(Commande::class);
	}

	public function poste()
	{
		return $this->belongsTo(Poste::class);
	}
}
