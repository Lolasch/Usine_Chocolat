<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::create([
            'nom' => 'Drinn',
            'prenom' => 'Hausen',
            'email' => 'drinn@example.com',
            'password' => bcrypt('password123'),
            'actif' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'nom' => 'Drinn',
            'prenom' => 'Hausen',
            'email' => 'drinn@example.com',
        ]);
    }

    public function test_user_email_is_unique()
    {
        $user1 = User::create([
            'nom' => 'Jean',
            'prenom' => 'Dupont',
            'email' => 'jean@example.com',
            'password' => bcrypt('password'),
            'actif' => true,
        ]);

        // Tentative de créer un deuxième utilisateur avec le même email
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'nom' => 'Pierre',
            'prenom' => 'Martin',
            'email' => 'jean@example.com',
            'password' => bcrypt('password'),
            'actif' => true,
        ]);
    }

    public function test_user_actif_casted_to_boolean()
    {
        $user = User::create([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'actif' => 1,
        ]);

        $this->assertTrue($user->actif);
        $this->assertIsBool($user->actif);
    }

    public function test_user_password_is_hashed()
    {
        $plainPassword = 'mysecretpassword';

        $user = User::create([
            'nom' => 'Secure',
            'prenom' => 'User',
            'email' => 'secure@example.com',
            'password' => bcrypt($plainPassword),
            'actif' => true,
        ]);

        $this->assertNotEquals($plainPassword, $user->password);
    }

    public function test_user_can_be_inactive()
    {
        $inactiveUser = User::create([
            'nom' => 'Inactive',
            'prenom' => 'User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('password'),
            'actif' => false,
        ]);

        $this->assertFalse($inactiveUser->actif);
        $this->assertDatabaseHas('users', [
            'email' => 'inactive@example.com',
            'actif' => false,
        ]);
    }
}
