<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NonConformite
 * 
 * @property int $id
 * @property int $commande_id
 * @property int|null $poste_id
 * @property string $description
 * @property Carbon $date_detection
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Commande $commande
 * @property Poste|null $poste
 *
 * @package App\Models
 */
class NonConformite extends Model
{
	protected $table = 'non_conformites';

	protected $casts = [
		'commande_id' => 'int',
		'poste_id' => 'int',
		'date_detection' => 'datetime'
	];

	protected $fillable = [
		'commande_id',
		'poste_id',
		'description',
		'date_detection'
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
