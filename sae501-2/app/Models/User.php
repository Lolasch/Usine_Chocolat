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
 * @property Carbon|null $deleted_at
 * @property string $password
 * @property string|null $remember_token
 *
 * @property Role $role
 * @property Collection|Equipe[] $equipes
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'users';

    protected $casts = [
        'actif' => 'bool',
        'role_id' => 'int',
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime' // 🔒 Soft deletes
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

    public function isSuperviseur(): bool
    {
        // Vérifier d'abord le rôle global
        if ($this->role?->nom === 'superviseur') {
            return true;
        }

        // Vérifier le rôle dans l'équipe (users_equipes)
        $equipe = $this->equipes()->first();
        if ($equipe) {
            $userEquipe = \DB::table('users_equipes')
                ->where('user_id', $this->id)
                ->where('equipe_id', $equipe->id)
                ->first();

            if ($userEquipe && $userEquipe->role_id) {
                $roleEquipe = Role::find($userEquipe->role_id);
                if ($roleEquipe && stripos(strtolower($roleEquipe->nom), 'superviseur') !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function usersEquipe()
    {
        return $this->hasOne(UsersEquipe::class, 'user_id');
    }
}
