<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Istanzia e verifica i permessi con Middleware
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    // Elenco dei campi per la il form di creazione o update dell'utente
    public function userFields()
    {
        $userFields = [
            'name' => ['text', 'Nome', 'required'],
            'surname' => ['text', 'Cognome', 'required'],
            'username' => ['text', 'Username', 'required'],
            'email' => ['email', 'Email', 'required'],
            'phone' => ['phone', 'Telefono', 'nullable'],
            'password' => ['password', 'Paswword', 'required'],
            'password_confirmation' => ['password', 'Conferma Password', 'required'],
        ];
        return $userFields;
    }
    // Elenco dei campi per la creazione o update dell'utente
    public function userRegistrationFields()
    {
        $userRegistrationFields = [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'username' => 'required|string|min:8|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'phone' => 'nullable',
            'password' => 'required|min:10|confirmed'
        ];
        return $userRegistrationFields;
    }
    // Crea la View con elenco utenti
    public function index(): View
    {
        $title = 'Elenco degli Utenti';
        return view('users.index', [
            'users' => User::latest('id')->paginate(10),
            'title' => $title
        ]);
    }
    // Crea la View del singolo utente
    public function show(User $user): View
    {
        $userFields = $this->userFields();
        $title = 'Informazioni Utente';
        return view('users.show', [
            'user' => $user,
            'title' => $title,
            'userFields' => $userFields
        ]);
    }
    // Crea la View per editare l'utente
    public function edit(User $user): View
    {
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'L\'Utente non ha le autorizzaizone per editare il proprio profilo');
            }
        }
        $userFields = $this->userFields();
        $title = 'Modifica Utente';
        return view(
            'users.edit',
            [
                'user' => $user,
                'roles' => Role::pluck('name')->all(),
                'userRoles' => $user->roles->pluck('name')->all(),
                'title' => $title,
                'userFields' => $userFields
            ]
        );
    }
    // Crea la View per la creazione di un nuovo utente
    public function create(): View
    {
        $userFields = $this->userFields();
        $title = 'Crea Utente';
        return view('users.create', [
            'roles' => Role::pluck('name')->all(),
            'title' => $title,
            'userFields' => $userFields
        ]);
    }
    // Salva i dati utente nel DB
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $user->assignRole($request->roles);
        return redirect()->route('users.index')
            ->withSuccess('L\'utente è stato creato');
    }
    // Aggiorna i dati utente nel DB
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();
        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }
        $user->update($input);
        $user->syncRoles($request->roles);
        return redirect()->back()
            ->withSuccess('L\'utente è stato aggiornato');
    }
    // Rimuovi l'utente
    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'Non hai le autorizzazioni necessarie');
        }
        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
        ->withSuccess('L\'utente è stato eliminato');
    }
}
