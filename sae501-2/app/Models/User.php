<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string|null $email
 * @property bool $actif
 * @property int $role_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 *
 * @property Role $role
 * @property Collection|Equipe[] $equipes
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'actif' => 'bool',
        'role_id' => 'int',
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'actif',
        'role_id',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'users_equipes')
                    ->withPivot('id')
                    ->withTimestamps();
    }
}
