<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
class App extends Controller
{
    // Istanzia l'oggetto verificando se è guest tranne che nelle pagine logout e home
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'home'
        ]);
    }
    public function loginSuccessMsg()
    {
        return 'Hai effettuato il Login con successo';
    }
    // Crea la View del Form di Registrazione
    public function register()
    {
        $userController = new UserController;
        $userFields = $userController->userFields();
        $title = 'Registrati';
        return view('auth.register', compact('title', 'userFields'));
    }
    // Salva l'utente nel DB
    public function store(Request $request)
    {
        $userController = new UserController;
        $userRegistrationFields = $userController->userRegistrationFields();
        $request->validate($userRegistrationFields);
        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('/home')
            ->withSuccess($this->loginSuccessMsg());
    }
    // Crea la View del Form di Login
    public function login()
    {
        $loginFields = [
            'username' => ['username', 'Username', 'required'],
            'password' => ['password', 'Password', 'required'],
        ];
        $title = 'Login';
        return view('auth.login', compact('title', 'loginFields'));
    }
    // Valida il form di Login e autentica l'utente
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $failMsg = 'Le tue credenziali sono errate';
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')
                ->withSuccess($this->loginSuccessMsg());
        }
        return back()->withErrors([
            'username' => $failMsg,
        ])->onlyInput('username');
    }
    // Gestisce il Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $logoutMsg = 'Ha effettuato il Logout';
        return redirect()->route('login')
            ->withSuccess($logoutMsg);;
    }
}
