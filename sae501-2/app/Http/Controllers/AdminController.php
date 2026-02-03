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
            if (!$user) {
                abort(403, 'Vous n\'avez pas accès à cette page.');
            }

            // Vérifier si l'utilisateur a un rôle admin/superviseur global
            $hasGlobalAccess = false;
            if ($user->role) {
                $roleAllowed = ['admin', 'administrateur', 'superviseur', 'supervisor'];
                $userRole = strtolower($user->role->nom);

                foreach ($roleAllowed as $role) {
                    if (stripos($userRole, $role) !== false) {
                        $hasGlobalAccess = true;
                        break;
                    }
                }
            }

            // Si pas d'accès global, vérifier le rôle dans l'équipe
            if (!$hasGlobalAccess) {
                $equipe = $user->equipes()->first();

                if ($equipe) {
                    $userEquipe = DB::table('users_equipes')
                        ->where('user_id', $user->id)
                        ->where('equipe_id', $equipe->id)
                        ->first();

                    if ($userEquipe && $userEquipe->role_id) {
                        $roleEquipe = Role::find($userEquipe->role_id);

                        if ($roleEquipe && stripos(strtolower($roleEquipe->nom), 'superviseur') !== false) {
                            $hasGlobalAccess = true;
                        }
                    }
                }
            }

            if (!$hasGlobalAccess) {
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

        // Récupérer les utilisateurs de l'équipe du superviseur
        $equipe = $user->equipes()->first();

        if (!$equipe) {
            $etudiants = collect([]);
        } else {
            // Récupérer les utilisateurs de cette équipe avec leurs rôles d'équipe
            $etudiantsRaw = $equipe->users()->with('role')->get();

            // Trouver le premier superviseur (chef d'équipe) ajouté à l'équipe
            $firstSuperviseur = DB::table('users_equipes')
                ->where('equipe_id', $equipe->id)
                ->leftJoin('roles', 'users_equipes.role_id', '=', 'roles.id')
                ->whereRaw("LOWER(COALESCE(roles.nom, '')) LIKE '%superviseur%'")
                ->orderBy('users_equipes.created_at')
                ->first();

            $firstSuperviseurId = $firstSuperviseur ? $firstSuperviseur->user_id : null;

            // Transformer en collection avec role_equipe inclus pour JSON
            $etudiants = $etudiantsRaw->map(function($etudiant) use ($equipe, $firstSuperviseurId) {
                $userEquipe = DB::table('users_equipes')
                    ->where('user_id', $etudiant->id)
                    ->where('equipe_id', $equipe->id)
                    ->first();

                $roleEquipe = null;
                if ($userEquipe && $userEquipe->role_id) {
                    $roleEquipe = Role::find($userEquipe->role_id);
                } else {
                    $roleEquipe = $etudiant->role; // Fallback sur le rôle global
                }

                $isTeamLeader = $etudiant->id === $firstSuperviseurId &&
                               $roleEquipe &&
                               stripos($roleEquipe->nom, 'superviseur') !== false;

                // Créer un tableau pour faciliter la sérialisation JSON
                return [
                    'id' => $etudiant->id,
                    'nom' => $etudiant->nom,
                    'prenom' => $etudiant->prenom,
                    'email' => $etudiant->email,
                    'role' => $etudiant->role ? [
                        'id' => $etudiant->role->id,
                        'nom' => $etudiant->role->nom
                    ] : null,
                    'role_equipe' => $roleEquipe ? [
                        'id' => $roleEquipe->id,
                        'nom' => $roleEquipe->nom
                    ] : null,
                    'is_team_leader' => $isTeamLeader
                ];
            });

            if ($search) {
                $etudiants = $etudiants->filter(function($etudiant) use ($search) {
                    $nom = strtolower($etudiant->nom ?? '');
                    $prenom = strtolower($etudiant->prenom ?? '');
                    $email = strtolower($etudiant->email ?? '');
                    $searchLower = strtolower($search);

                    return str_contains($nom, $searchLower) ||
                           str_contains($prenom, $searchLower) ||
                           str_contains($email, $searchLower);
                });
            }
        }

        $roles = Role::all();
        $postes = Poste::orderBy('ordre')->get();

        // Calculer les statistiques pour l'équipe du superviseur
        if ($equipe) {
            // Nombre d'utilisateurs dans l'équipe
            $nbUtilisateurs = $equipe->users()->count();

            // Vérifier si tous les utilisateurs ont un rôle défini dans l'équipe
            $nbUtilisateursAvecRole = DB::table('users_equipes')
                ->where('equipe_id', $equipe->id)
                ->whereNotNull('role_id')
                ->count();

            // Nombre de postes assignés dans l'équipe
            $nbPostesAssignes = DB::table('users_equipes')
                ->where('equipe_id', $equipe->id)
                ->whereNotNull('poste_id')
                ->distinct('poste_id')
                ->count('poste_id');
        } else {
            $nbUtilisateurs = 0;
            $nbUtilisateursAvecRole = 0;
            $nbPostesAssignes = 0;
        }

        $stats = [
            'utilisateurs_actifs' => $nbUtilisateurs,
            'roles' => $nbUtilisateursAvecRole,
            'postes' => $nbPostesAssignes,
        ];

        // Vérifier si l'utilisateur connecté est le vrai chef (superviseur global)
        $isGlobalSupervisor = false;
        if ($user->role) {
            $roleAllowed = ['admin', 'administrateur', 'superviseur', 'supervisor'];
            $userRole = strtolower($user->role->nom);

            foreach ($roleAllowed as $role) {
                if (stripos($userRole, $role) !== false) {
                    $isGlobalSupervisor = true;
                    break;
                }
            }
        }

        return view('admin', [
            'etudiants' => $etudiants,
            'roles' => $roles,
            'postes' => $postes,
            'stats' => $stats,
            'selectedUser' => null,
            'search' => $search,
            'isAdmin' => $isAdmin,
            'isGlobalSupervisor' => $isGlobalSupervisor
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
        $postes = Poste::orderBy('ordre')->get();

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

    public function getUserDetails(User $user)
    {
        // Charger les relations nécessaires
        $user->load(['role', 'equipes']);

        // Récupérer tous les postes disponibles
        $postes = Poste::orderBy('ordre')->get();

        // Récupérer l'équipe du superviseur connecté
        $authUser = auth()->user();
        $equipe = $authUser->equipes()->first();

        if (!$equipe) {
            return response()->json([
                'error' => 'Vous n\'êtes pas associé à une équipe',
                'user' => $user,
                'postes' => $postes,
                'poste_actuel' => null,
                'role_actuel' => null
            ], 200);
        }

        // Récupérer le rôle et poste de l'utilisateur dans cette équipe spécifique
        $userEquipe = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->first();

        $posteActuel = null;
        $roleActuel = null;

        if ($userEquipe) {
            if (isset($userEquipe->poste_id)) {
                $posteActuel = Poste::find($userEquipe->poste_id);
            }
            if (isset($userEquipe->role_id)) {
                $roleActuel = Role::find($userEquipe->role_id);
            }
        }

        // Si pas de rôle dans l'équipe, utiliser le rôle global
        if (!$roleActuel && $user->role) {
            $roleActuel = $user->role;
        }

        Log::info('getUserDetails', [
            'user_id' => $user->id,
            'equipe_id' => $equipe->id,
            'userEquipe' => $userEquipe,
            'role_actuel' => $roleActuel
        ]);

        return response()->json([
            'user' => $user,
            'postes' => $postes,
            'poste_actuel' => $posteActuel,
            'role_actuel' => $roleActuel,
            'equipe_id' => $equipe->id
        ]);
    }

    public function changeRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        // Récupérer l'équipe du superviseur connecté
        $authUser = auth()->user();

        // Empêcher le superviseur de modifier son propre rôle
        if ($user->id === $authUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier votre propre rôle'
            ], 403);
        }

        // Empêcher la modification du superviseur du groupe (rôle global superviseur)
        if ($user->role && stripos($user->role->nom, 'superviseur') !== false) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier le rôle du superviseur du groupe'
            ], 403);
        }

        $equipe = $authUser->equipes()->first();

        if (!$equipe) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas associé à une équipe'
            ], 403);
        }

        // Modifier le rôle uniquement dans users_equipes pour cette équipe
        $userEquipeExists = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->exists();

        if (!$userEquipeExists) {
            return response()->json([
                'success' => false,
                'message' => 'L\'utilisateur n\'est pas dans votre équipe'
            ], 403);
        }

        DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->update(['role_id' => $validated['role_id'], 'updated_at' => now()]);

        $role = Role::find($validated['role_id']);

        // Vérifier que l'update a bien été effectué
        $verification = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->first();

        Log::info('Changement de rôle dans l\'équipe', [
            'user_id' => $user->id,
            'equipe_id' => $equipe->id,
            'nouveau_role_id' => $validated['role_id'],
            'nouveau_role_nom' => $role->nom,
            'verification_role_id' => $verification->role_id ?? 'NULL',
            'by_user_id' => $authUser->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rôle modifié avec succès pour cette équipe',
            'role' => $role
        ]);
    }

    public function changePoste(Request $request, User $user)
    {
        $validated = $request->validate([
            'poste_id' => 'required|exists:postes,id'
        ]);

        // Récupérer l'équipe du superviseur connecté
        $authUser = auth()->user();

        // Empêcher le superviseur de modifier son propre poste
        if ($user->id === $authUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier votre propre poste'
            ], 403);
        }

        // Empêcher la modification du poste du superviseur du groupe (rôle global superviseur)
        if ($user->role && stripos($user->role->nom, 'superviseur') !== false) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier le poste du superviseur du groupe'
            ], 403);
        }

        $equipe = $authUser->equipes()->first();

        if (!$equipe) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas associé à une équipe'
            ], 403);
        }

        // Mettre à jour le poste uniquement pour cette équipe
        // Récupérer l'ancien poste avant la modification
        $oldPosteId = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->value('poste_id');

        $updated = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->update(['poste_id' => $validated['poste_id']]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'L\'utilisateur n\'est pas dans votre équipe'
            ], 403);
        }

        $poste = Poste::find($validated['poste_id']);

        // Calculer si c'est un nouveau poste distinct
        $nbPostesAssignes = DB::table('users_equipes')
            ->where('equipe_id', $equipe->id)
            ->whereNotNull('poste_id')
            ->distinct('poste_id')
            ->count('poste_id');

        return response()->json([
            'success' => true,
            'message' => 'Poste modifié avec succès',
            'poste' => $poste,
            'had_poste_before' => !is_null($oldPosteId),
            'nb_postes' => $nbPostesAssignes
        ]);
    }

    public function deleteAjax(User $user)
    {
        $userName = $user->prenom . ' ' . $user->nom;

        // Récupérer l'équipe du superviseur connecté
        $authUser = auth()->user();

        // Empêcher le superviseur de se supprimer lui-même
        if ($user->id === $authUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous retirer de votre propre équipe'
            ], 403);
        }

        // Empêcher la suppression du superviseur du groupe (rôle global superviseur)
        if ($user->role && stripos($user->role->nom, 'superviseur') !== false) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas retirer le superviseur du groupe de l\'équipe'
            ], 403);
        }

        $equipe = $authUser->equipes()->first();

        if (!$equipe) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas associé à une équipe'
            ], 403);
        }

        // Supprimer l'utilisateur de l'équipe (pas de la base de données)
        $deleted = DB::table('users_equipes')
            ->where('user_id', $user->id)
            ->where('equipe_id', $equipe->id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'L\'utilisateur n\'est pas dans votre équipe'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => "$userName a été retiré de l'équipe avec succès"
        ]);
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

    // ===== GESTION DES POSTES =====

    /**
     * Créer un nouveau poste
     */
    public function storePoste(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255|unique:postes,nom',
                'ordre' => 'required|integer|min:1',
                'duree_cible' => 'nullable|integer|min:1'
            ]);

            $poste = Poste::create([
                'nom' => $validated['nom'],
                'ordre' => $validated['ordre'],
                'duree_cible' => $validated['duree_cible'] ?? null,
                'actif' => true
            ]);

            Log::info('Nouveau poste créé', [
                'poste_id' => $poste->id,
                'nom' => $poste->nom,
                'ordre' => $poste->ordre,
                'created_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Poste créé avec succès',
                'poste' => $poste
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du poste: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un poste
     */
    public function updatePoste(Request $request, Poste $poste)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255|unique:postes,nom,' . $poste->id
            ]);

            $poste->nom = $validated['nom'];
            $poste->save();

            Log::info('Poste modifié', [
                'poste_id' => $poste->id,
                'nouveau_nom' => $poste->nom,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Poste modifié avec succès',
                'poste' => $poste
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la modification du poste: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un poste
     */
    public function destroyPoste(Poste $poste)
    {
        try {
            // Vérifier si des commandes ACTIVES sont dans ce poste (date_sortie null = commande en cours)
            $commandesActivesCount = DB::table('commandes_postes')
                ->where('poste_id', $poste->id)
                ->whereNull('date_sortie')
                ->count();

            if ($commandesActivesCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce poste car ' . $commandesActivesCount . ' commande(s) y sont actuellement en cours. Veuillez d\'abord les traiter.'
                ], 400);
            }

            // Supprimer l'historique des commandes qui sont passées par ce poste
            $historiqueCount = DB::table('commandes_postes')
                ->where('poste_id', $poste->id)
                ->count();

            if ($historiqueCount > 0) {
                DB::table('commandes_postes')
                    ->where('poste_id', $poste->id)
                    ->delete();

                Log::info('Historique des commandes supprimé pour le poste', [
                    'poste_id' => $poste->id,
                    'historique_count' => $historiqueCount
                ]);
            }

            // Vérifier si des utilisateurs sont affectés à ce poste
            $usersCount = DB::table('users_equipes')
                ->where('poste_id', $poste->id)
                ->count();

            if ($usersCount > 0) {
                // Retirer l'affectation du poste pour tous les utilisateurs
                DB::table('users_equipes')
                    ->where('poste_id', $poste->id)
                    ->update(['poste_id' => null]);

                Log::info('Utilisateurs désaffectés du poste avant suppression', [
                    'poste_id' => $poste->id,
                    'users_count' => $usersCount
                ]);
            }

            $posteNom = $poste->nom;
            $poste->delete();

            Log::info('Poste supprimé', [
                'poste_nom' => $posteNom,
                'deleted_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Poste supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du poste: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déplacer un poste vers le haut (diminuer l'ordre)
     */
    public function movePosteUp(Poste $poste)
    {
        try {
            // Trouver le poste précédent
            $previousPoste = Poste::where('ordre', '<', $poste->ordre)
                ->orderBy('ordre', 'desc')
                ->first();

            if (!$previousPoste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce poste est déjà en première position'
                ]);
            }

            // Échanger les ordres
            $tempOrdre = $poste->ordre;
            $poste->ordre = $previousPoste->ordre;
            $previousPoste->ordre = $tempOrdre;

            $poste->save();
            $previousPoste->save();

            Log::info('Poste déplacé vers le haut', [
                'poste_id' => $poste->id,
                'new_ordre' => $poste->ordre,
                'moved_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Poste déplacé avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du déplacement du poste: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déplacer un poste vers le bas (augmenter l'ordre)
     */
    public function movePosteDown(Poste $poste)
    {
        try {
            // Trouver le poste suivant
            $nextPoste = Poste::where('ordre', '>', $poste->ordre)
                ->orderBy('ordre', 'asc')
                ->first();

            if (!$nextPoste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce poste est déjà en dernière position'
                ]);
            }

            // Échanger les ordres
            $tempOrdre = $poste->ordre;
            $poste->ordre = $nextPoste->ordre;
            $nextPoste->ordre = $tempOrdre;

            $poste->save();
            $nextPoste->save();

            Log::info('Poste déplacé vers le bas', [
                'poste_id' => $poste->id,
                'new_ordre' => $poste->ordre,
                'moved_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Poste déplacé avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du déplacement du poste: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }
}
