<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Visiteur
 * 
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Commande[] $commandes
 *
 * @package App\Models
 */
class Visiteur extends Model
{
	protected $table = 'visiteurs';

	protected $fillable = [
		'nom',
		'prenom',
		'email'
	];

	public function commandes()
	{
		return $this->hasMany(Commande::class);
	}
}
