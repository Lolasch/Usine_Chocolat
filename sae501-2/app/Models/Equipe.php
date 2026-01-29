<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipe
 *
 * @property int $id
 * @property string $nom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Equipe extends Model
{
    protected $table = 'equipes';

    protected $fillable = [
        'nom'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_equipes')
                    ->withPivot('id')
                    ->withTimestamps();
    }
}
