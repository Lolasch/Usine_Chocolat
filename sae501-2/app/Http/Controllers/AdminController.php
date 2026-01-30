<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Poste;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !$user->role) {
                abort(403, 'Vous n\'avez pas accès à cette page.');
            }

            $roleAllowed = ['admin', 'administrateur', 'superviseur', 'supervisor'];
            $userRole = strtolower($user->role->nom);
            $hasAccess = false;

            foreach ($roleAllowed as $role) {
                if (stripos($userRole, $role) !== false) {
                    $hasAccess = true;
                    break;
                }
            }

            if (!$hasAccess) {
                abort(403, 'Vous n\'avez pas accès à cette page. Seul un administrateur ou superviseur peut accéder à cette section.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');
        $isAdmin = stripos($user->role->nom, 'admin') !== false;

        // 🟢 FILTRE : role_id = 2 (opérateur)
        if ($isAdmin) {
            $etudiants = User::where('role_id', 2)->with('role');
        } else {
            $equipe = $user->equipes()->first();
            if ($equipe) {
                $etudiants = $equipe->users()
                    ->where('role_id', 2)
                    ->with('role');
            } else {
                $etudiants = User::where('role_id', 2)
                    ->where('id', '=', null)
                    ->with('role');
            }
        }

        if ($search) {
            $etudiants = $etudiants->where(function ($query) use ($search) {
                $query->where('nom', 'like', "%$search%")
                      ->orWhere('prenom', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            });
        }

        $etudiants = $etudiants->get();

        $roles = Role::all();
        $postes = Poste::all();

        $stats = [
            'utilisateurs_actifs' => User::where('actif', true)->count(),
            'roles' => Role::count(),
            'postes' => Poste::count(),
        ];

        return view('admin', [
            'etudiants' => $etudiants,
            'roles' => $roles,
            'postes' => $postes,
            'stats' => $stats,
            'selectedUser' => null,
            'search' => $search,
            'isAdmin' => $isAdmin
        ]);
    }

    public function show(User $user, Request $request)
    {
        $authUser = auth()->user();
        $search = $request->input('search', '');
        $isAdmin = stripos($authUser->role->nom, 'admin') !== false;

        // 🟢 FILTRE : role_id = 2 (opérateur)
        if ($isAdmin) {
            $users = User::where('role_id', 2)->with('role');
        } else {
            $equipe = $authUser->equipes()->first();
            if ($equipe) {
                $users = $equipe->users()
                    ->where('role_id', 2)
                    ->with('role');
            } else {
                $users = User::where('role_id', 2)
                    ->where('id', '=', null)
                    ->with('role');
            }
        }

        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('nom', 'like', "%$search%")
                      ->orWhere('prenom', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $users->get();

        $roles = Role::all();
        $postes = Poste::all();

        $stats = [
            'utilisateurs_actifs' => User::where('actif', true)->count(),
            'roles' => Role::count(),
            'postes' => Poste::count(),
        ];

        $user->load('role');

        return view('admin', [
            'etudiants' => $users,
            'roles' => $roles,
            'postes' => $postes,
            'stats' => $stats,
            'selectedUser' => $user,
            'search' => $search,
            'isAdmin' => $isAdmin
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'actif' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['actif'] = $request->has('actif') ? true : false;

        $role = Role::find($validated['role_id']);

        if (stripos($role->nom, 'superviseur') !== false) {
            $nomBase = strtolower(str_replace('@', '', explode('@', $validated['email'])[0]));
            $nomEquipe = $nomBase;
            $compteur = 1;

            while (Equipe::where('nom', $nomEquipe)->exists()) {
                $nomEquipe = $nomBase . $compteur;
                $compteur++;
            }

            $user = null;
            DB::transaction(function () use ($validated, &$user, $nomEquipe) {
                $user = User::create($validated);
                $equipe = Equipe::create(['nom' => $nomEquipe]);
                $user->equipes()->attach($equipe->id);
            });

            return redirect()->route('admin.index')
                           ->with('success', "Utilisateur ET équipe '$nomEquipe' créés avec succès.");
        }

        User::create($validated);

        return redirect()->route('admin.index')
                       ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $postes = Poste::all();

        return view('admin.edit', [
            'user' => $user,
            'roles' => $roles,
            'postes' => $postes
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'actif' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->input('password'));
        }

        $validated['actif'] = $request->has('actif') ? true : false;

        $user->update($validated);

        return redirect()->route('admin.show', $user)
                       ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.index')
                       ->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $search = $request->input('q', '');

        $users = User::where('nom', 'like', "%$search%")
                     ->orWhere('prenom', 'like', "%$search%")
                     ->orWhere('email', 'like', "%$search%")
                     ->with('role')
                     ->limit(10)
                     ->get();

        return response()->json($users);
    }

    public function getAvailableOperators(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');

        // 🟢 RÉCUPÉRER UNIQUEMENT role_id = 2 (opérateurs)
        $query = User::where('role_id', 2)->where('actif', true)->with('role');

        // Si superviseur, exclure ceux déjà dans son équipe
        if (!$user->role || stripos($user->role->nom, 'admin') === false) {
            $equipe = $user->equipes()->first();
            if ($equipe) {
                $query->whereNotExists(function ($q) use ($equipe) {
                    $q->select(DB::raw(1))
                      ->from('users_equipes')
                      ->whereColumn('users_equipes.user_id', 'users.id')
                      ->where('users_equipes.equipe_id', $equipe->id);
                });
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            });
        }

        $operators = $query->get();

        return response()->json($operators);
    }

    public function equipes(Request $request)
    {
        $search = $request->input('search', '');

        $query = Equipe::withCount('users');

        if ($search) {
            $query->where('nom', 'like', "%$search%");
        }

        $equipes = $query->get();

        return response()->json($equipes);
    }

    public function addOperator(Request $request, User $user)
    {
        try {
            $user->load('role');

            $authUser = auth()->user();
            $roleName = strtolower($authUser->role->nom ?? '');

            $isSuperviseur = str_contains($roleName, 'superviseur');
            $isAdmin = str_contains($roleName, 'admin');

            if (!$isSuperviseur && !$isAdmin) {
                return response()->json([
                    'error' => 'Seul un superviseur ou admin peut ajouter des membres'
                ], 403);
            }

            // 🟢 VÉRIFICATION : role_id = 2 (opérateur)
            if ($user->role_id != 2) {
                return response()->json([
                    'error' => 'Cet utilisateur n\'est pas un opérateur (role_id doit être 2)',
                    'debug' => [
                        'user_id' => $user->id,
                        'role_id' => $user->role_id,
                        'role_nom' => $user->role->nom ?? 'NULL'
                    ]
                ], 400);
            }

            // Déterminer l'équipe
            if ($isSuperviseur) {
                $equipe = $authUser->equipes()->first();

                if (!$equipe) {
                    $nomBase = strtolower(str_replace('@', '', explode('@', $authUser->email)[0]));
                    $nomEquipe = $nomBase;
                    $compteur = 1;

                    while (Equipe::where('nom', $nomEquipe)->exists()) {
                        $nomEquipe = $nomBase . $compteur;
                        $compteur++;
                    }

                    $equipe = Equipe::create(['nom' => $nomEquipe]);
                    $authUser->equipes()->attach($equipe->id);
                }
            } else {
                $equipeId = $request->input('equipe_id');
                $equipe = $equipeId ? Equipe::find($equipeId) : Equipe::first();

                if (!$equipe) {
                    $equipe = Equipe::create(['nom' => 'equipe_defaut']);
                }
            }

            // Vérifier si déjà dans l'équipe
            $exists = DB::table('users_equipes')
                ->where('user_id', $user->id)
                ->where('equipe_id', $equipe->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => $user->prenom . ' ' . $user->nom . ' est déjà dans l\'équipe "' . $equipe->nom . '"'
                ], 400);
            }

            // Ajouter dans la table pivot
            DB::table('users_equipes')->insert([
                'user_id' => $user->id,
                'equipe_id' => $equipe->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Opérateur ajouté à l\'équipe', [
                'user_id' => $user->id,
                'user_nom' => $user->nom . ' ' . $user->prenom,
                'equipe_id' => $equipe->id,
                'equipe_nom' => $equipe->nom,
                'by_user_id' => $authUser->id
            ]);

            return response()->json([
                'success' => true,
                'message' => $user->prenom . ' ' . $user->nom . ' ajouté(e) à l\'équipe "' . $equipe->nom . '"'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur addOperator: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeOperator(Request $request, User $operator)
    {
        try {
            $user = auth()->user();
            $isSuperviseur = stripos($user->role->nom, 'superviseur') !== false;

            if (!$isSuperviseur) {
                return response()->json([
                    'error' => 'Seul un superviseur peut retirer des membres'
                ], 403);
            }

            $equipe = $user->equipes()->first();

            if (!$equipe) {
                return response()->json([
                    'error' => 'Vous n\'avez pas d\'équipe assignée'
                ], 404);
            }

            $deleted = DB::table('users_equipes')
                ->where('user_id', $operator->id)
                ->where('equipe_id', $equipe->id)
                ->delete();

            if ($deleted) {
                Log::info('Opérateur retiré de l\'équipe', [
                    'user_id' => $operator->id,
                    'equipe_id' => $equipe->id,
                    'by_user_id' => $user->id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Membre retiré avec succès'
                ]);
            } else {
                return response()->json([
                    'error' => 'Ce membre n\'est pas dans votre équipe'
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Erreur removeOperator: ' . $e->getMessage());

            return response()->json([
                'error' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }
}
