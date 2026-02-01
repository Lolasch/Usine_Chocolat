<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersEquipe
 *
 * @property int $id
 * @property int $equipe_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 *
 * @property Equipe $equipe
 * @property User $user
 *
 * @package App\Models
 */
class UsersEquipe extends Model
{
	protected $table = 'users_equipes';

	protected $casts = [
		'equipe_id' => 'int',
		'user_id' => 'int',
		'poste_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'equipe_id',
		'user_id',
		'poste_id',
		'role_id'
	];

	public function equipe()
	{
		return $this->belongsTo(Equipe::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function poste()
	{
		return $this->belongsTo(Poste::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
