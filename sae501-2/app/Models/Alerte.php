<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Alerte
 * 
 * @property int $id
 * @property string|null $type
 * @property string $message
 * @property Carbon $date_alerte
 * @property bool $resolue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Alerte extends Model
{
	protected $table = 'alertes';

	protected $casts = [
		'date_alerte' => 'datetime',
		'resolue' => 'bool'
	];

	protected $fillable = [
		'type',
		'message',
		'date_alerte',
		'resolue'
	];
}
