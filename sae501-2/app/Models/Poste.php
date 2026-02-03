<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Poste
 *
 * @property int $id
 * @property string $nom
 * @property int $ordre
 * @property bool $actif
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Commande[] $commandes
 * @property Collection|NonConformite[] $non_conformites
 *
 * @package App\Models
 */
class Poste extends Model
{
	protected $table = 'postes';

	protected $casts = [
		'ordre' => 'int',
		'actif' => 'bool'
	];

	protected $fillable = [
		'nom',
		'ordre',
		'actif'
	];

	public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commandes_postes')
                    ->withPivot('id', 'date_entree', 'date_sortie', 'conforme')
                    ->whereNull('commandes_postes.date_sortie')
                    ->with(['visiteur', 'chocolat'])
                    ->withTimestamps();
    }

	public function non_conformites()
	{
		return $this->hasMany(NonConformite::class);
	}
}
