<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $type
 * @property int $quantite
 * @property int $seuil_min
 * @property bool $actif
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ConsommationsStock[] $consommations_stocks
 *
 * @package App\Models
 */
class Stock extends Model
{
	protected $table = 'stocks';

	protected $casts = [
		'quantite' => 'int',
		'seuil_min' => 'int',
		'actif' => 'bool'
	];

	protected $fillable = [
		'nom',
		'type',
		'quantite',
		'seuil_min',
		'actif'
	];

	public function consommations_stocks()
	{
		return $this->hasMany(ConsommationsStock::class);
	}
}
