<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_and_retrieved()
    {
        $user = User::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@example.com',
            'password' => bcrypt('password123'),
            'actif' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'nom' => 'Dupont',
            'prenom' => 'Jean',
        ]);

        $retrievedUser = User::find($user->id);
        $this->assertEquals('Dupont', $retrievedUser->nom);
    }

    public function test_user_full_name_generation()
    {
        $user = User::create([
            'nom' => 'Martin',
            'prenom' => 'Pierre',
            'email' => 'pierre@example.com',
            'password' => bcrypt('password'),
            'actif' => true,
        ]);

        $fullName = $user->prenom . ' ' . $user->nom;
        $this->assertEquals('Pierre Martin', $fullName);
    }

    public function test_user_inactivity_prevents_access()
    {
        $inactiveUser = User::create([
            'nom' => 'Inactive',
            'prenom' => 'User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('password'),
            'actif' => false,
        ]);

        $this->assertFalse($inactiveUser->actif);
    }

    public function test_user_can_update_profile()
    {
        $user = User::create([
            'nom' => 'Original',
            'prenom' => 'Name',
            'email' => 'original@example.com',
            'password' => bcrypt('password'),
            'actif' => true,
        ]);

        $user->update([
            'nom' => 'Updated',
            'prenom' => 'Name',
        ]);

        $this->assertEquals('Updated', $user->fresh()->nom);
    }

    public function test_multiple_users_can_exist()
    {
        $users = [
            ['nom' => 'User1', 'prenom' => 'First', 'email' => 'user1@example.com'],
            ['nom' => 'User2', 'prenom' => 'Second', 'email' => 'user2@example.com'],
            ['nom' => 'User3', 'prenom' => 'Third', 'email' => 'user3@example.com'],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'password' => bcrypt('password'),
                'actif' => true,
            ]));
        }

        $this->assertDatabaseCount('users', 3);
        $this->assertEquals(3, User::where('actif', true)->count());
    }
}
