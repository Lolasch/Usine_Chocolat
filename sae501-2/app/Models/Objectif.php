<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Objectif
 * 
 * @property int $id
 * @property string|null $type
 * @property int $valeur
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Objectif extends Model
{
	protected $table = 'objectifs';

	protected $casts = [
		'valeur' => 'int'
	];

	protected $fillable = [
		'type',
		'valeur',
		'description'
	];
}
