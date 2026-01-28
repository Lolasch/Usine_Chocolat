<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Poste;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $postes = Poste::all();

        $stats = [
            'utilisateurs_actifs' => User::count(),
            'roles' => Role::count(),
            'postes' => Poste::count(),
        ];

        return view('admin', [
            'etudiants' => $users,
            'roles' => $roles,
            'postes' => $postes,
            'stats' => $stats,
            'selectedUser' => null
        ]);
    }

    public function show(User $user)
    {
        $users = User::all();
        $roles = Role::all();
        $postes = Poste::all();

        $stats = [
            'utilisateurs_actifs' => User::count(),
            'roles' => Role::count(),
            'postes' => Poste::count(),
        ];

        return view('admin', [
            'etudiants' => $users,
            'roles' => $roles,
            'postes' => $postes,
            'stats' => $stats,
            'selectedUser' => $user
        ]);
    }
}
