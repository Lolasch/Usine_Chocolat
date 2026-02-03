<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Equipe;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:'.User::class],
            'password' => [
                'required',
                'confirmed',
                'min:12',
                Rules\Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), // 🔒 Vérifier Have I Been Pwned API
            ],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // ✅ Déclarer $user en dehors de la transaction
        $user = null;

        DB::transaction(function () use ($request, &$user) {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'actif' => true,
            ]);

            // 🆕 AUTO ÉQUIPE SUPERVISEUR (nom unique basé sur email)
            $role = $user->role;
            if ($role && stripos($role->nom, 'superviseur') !== false) {
                $nomBase = strtolower(str_replace('@', '', explode('@', $user->email)[0]));
                $nomEquipe = $nomBase;
                $compteur = 1;

                // Trouver nom unique
                while (Equipe::where('nom', $nomEquipe)->exists()) {
                    $nomEquipe = $nomBase . $compteur;
                    $compteur++;
                }

                $equipe = Equipe::create(['nom' => $nomEquipe]);

                // ✅ Attacher l'équipe AVEC le role_id dans la table pivot
                $user->equipes()->attach($equipe->id, [
                    'role_id' => $request->role_id, // Même rôle que celui choisi à l'inscription
                    'poste_id' => null
                ]);
            }
        });

        // 🔒 Dispatcher l'événement Registered AVANT login (envoie email de vérification)
        event(new Registered($user));

        // 🔒 NE PAS auto-login jusqu'à vérification email
        // Auth::login($user); <- COMMENTÉ pour forcer vérification

        return redirect()->route('verification.notice')
            ->with('status', 'Un email de confirmation a été envoyé. Veuillez vérifier votre boîte de réception.');
    }
}
