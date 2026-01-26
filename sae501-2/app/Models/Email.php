<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Email
 * 
 * @property int $id
 * @property int|null $commande_id
 * @property string|null $type
 * @property Carbon $date_envoi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Commande|null $commande
 *
 * @package App\Models
 */
class Email extends Model
{
	protected $table = 'emails';

	protected $casts = [
		'commande_id' => 'int',
		'date_envoi' => 'datetime'
	];

	protected $fillable = [
		'commande_id',
		'type',
		'date_envoi'
	];

	public function commande()
	{
		return $this->belongsTo(Commande::class);
	}
}
