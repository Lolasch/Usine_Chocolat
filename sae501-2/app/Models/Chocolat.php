<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Chocolat
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property bool $disponible
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Commande[] $commandes
 *
 * @package App\Models
 */
class Chocolat extends Model
{
	protected $table = 'chocolats';

	protected $casts = [
		'disponible' => 'bool'
	];

	protected $fillable = [
		'nom',
		'description',
		'disponible'
	];

	public function commandes()
	{
		return $this->hasMany(Commande::class);
	}
}
