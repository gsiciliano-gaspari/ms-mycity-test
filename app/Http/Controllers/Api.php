<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Log;

class Api extends Controller
{
    public function register(Request $request)
    {
        $userController = new UserController;
        $userRegistrationFields = $userController->userRegistrationFields();
        $validate = Validator::make($request->all(), $userRegistrationFields);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Errore di validazione',
                'data' => $validate->errors(),
            ], 403);
        }
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        $response = [
            'status' => 'success',
            'message' => 'L\'utente è stato creato',
            'data' => $data,
        ];
        return response()->json($response, 201);
    }
    // Login via API
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Errore di validazione',
                'data' => $validate->errors(),
            ], 403);
        }
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Credenziali errate'
            ], 401);
        }
        $data['token'] = $user->createToken($request->username)->plainTextToken;
        $data['user'] = $user;
        $response = [
            'status' => 'success',
            'message' => 'Utente Loggato',
            'data' => $data,
        ];
        return response()->json($response, 200);
    }
    // Logout via API
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Utente disconesso'
        ], 200);
    }
    // Visualizza lista utenti via API
    public function index()
    {
        $users = User::all();
        Log::debug($users);
        if (is_null($users->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Nessun utente trovato',
            ], 200);
        }
        $response = [
            'status' => 'success',
            'message' => 'Lista degli utenti:',
            'data' => $users,
        ];
        return response()->json($response, 200);
    }
}
