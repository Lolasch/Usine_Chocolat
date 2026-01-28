<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Poste;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Vérifier que l'utilisateur est admin ou superviseur
            $user = auth()->user();
            if (!$user || !$user->role) {
                abort(403, 'Vous n\'avez pas accès à cette page.');
            }

            $roleAllowed = [
                'admin',
                'administrateur',
                'superviseur',
                'supervisor'
            ];

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

    /**
     * Affiche la page admin avec liste des utilisateurs et statistiques
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');
        $isAdmin = stripos($user->role->nom, 'admin') !== false;

        // Charger les opérateurs de l'équipe du superviseur ou tous les opérateurs pour l'admin
        if ($isAdmin) {
            // L'admin voit tous les opérateurs
            $etudiants = User::whereHas('role', function ($query) {
                $query->where('nom', 'like', '%Opérateur%');
            })
            ->with('role');
        } else {
            // Le superviseur voit ses opérateurs (via l'équipe)
            $equipe = $user->equipes()->first();

            if ($equipe) {
                $etudiants = $equipe->users()
                    ->whereHas('role', function ($query) {
                        $query->where('nom', 'like', '%Opérateur%');
                    })
                    ->with('role');
            } else {
                // Si le superviseur n'a pas d'équipe, il voit une liste vide
                $etudiants = User::whereHas('role', function ($query) {
                    $query->where('nom', 'like', '%Opérateur%');
                })
                ->where('id', '=', null) // Résultat vide
                ->with('role');
            }
        }

        // Appliquer la recherche si elle existe
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

        // Statistiques
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

    /**
     * Affiche un utilisateur spécifique avec ses détails
     */
    public function show(User $user, Request $request)
    {
        $search = $request->input('search', '');

        // Récupérer les utilisateurs
        if ($search) {
            $users = User::where('nom', 'like', "%$search%")
                         ->orWhere('prenom', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%")
                         ->with('role')
                         ->get();
        } else {
            $users = User::with('role')->get();
        }

        $roles = Role::all();
        $postes = Poste::all();

        // Statistiques
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
            'search' => $search
        ]);
    }

    /**
     * Crée un nouvel utilisateur
     */
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

        User::create($validated);

        return redirect()->route('admin.index')
                       ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur
     */
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

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'actif' => 'boolean',
        ]);

        // Ajouter le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->input('password'));
        }

        $validated['actif'] = $request->has('actif') ? true : false;

        $user->update($validated);

        return redirect()->route('admin.show', $user)
                       ->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.index')
                       ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Recherche des utilisateurs (pour AJAX)
     */
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

    /**
     * Récupère les opérateurs disponibles pour ajouter à l'équipe
     */
    public function getAvailableOperators(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');
        $filter = $request->input('filter', ''); // pour filtrer par poste

        // Récupérer l'équipe du superviseur
        $equipe = $user->equipes()->first();

        // Récupérer tous les opérateurs
        $query = User::whereHas('role', function ($q) {
            $q->where('nom', 'like', '%Opérateur%');
        });

        // Exclure les opérateurs déjà dans l'équipe
        if ($equipe) {
            $query->whereNotIn('id', $equipe->users()->pluck('users.id'));
        }

        // Appliquer la recherche
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            });
        }

        $operators = $query->with('role')->get();

        return response()->json($operators);
    }

    /**
     * Ajoute un opérateur à l'équipe du superviseur
     */
    public function addOperator(Request $request, User $operator)
    {
        $user = auth()->user();
        $isSuperviseur = stripos($user->role->nom, 'superviseur') !== false;

        // Seul un superviseur peut ajouter des opérateurs à son équipe
        if (!$isSuperviseur) {
            return response()->json(['error' => 'Seul un superviseur peut ajouter des opérateurs'], 403);
        }

        $equipe = $user->equipes()->first();

        if (!$equipe) {
            return response()->json(['error' => 'Vous n\'avez pas d\'équipe assignée'], 404);
        }

        // Vérifier que c'est un opérateur
        if (stripos($operator->role->nom, 'Opérateur') === false) {
            return response()->json(['error' => 'Cet utilisateur n\'est pas un opérateur'], 400);
        }

        // Ajouter l'opérateur à l'équipe s'il n'y est pas déjà
        if (!$equipe->users()->where('user_id', $operator->id)->exists()) {
            $equipe->users()->attach($operator->id);
        }

        return response()->json(['success' => true, 'message' => 'Opérateur ajouté avec succès']);
    }

    /**
     * Retire un opérateur de l'équipe du superviseur
     */
    public function removeOperator(Request $request, User $operator)
    {
        $user = auth()->user();
        $isSuperviseur = stripos($user->role->nom, 'superviseur') !== false;

        // Seul un superviseur peut retirer des opérateurs de son équipe
        if (!$isSuperviseur) {
            return response()->json(['error' => 'Seul un superviseur peut retirer des opérateurs'], 403);
        }

        $equipe = $user->equipes()->first();

        if (!$equipe) {
            return response()->json(['error' => 'Vous n\'avez pas d\'équipe assignée'], 404);
        }

        $equipe->users()->detach($operator->id);

        return response()->json(['success' => true, 'message' => 'Opérateur retiré avec succès']);
    }
}
