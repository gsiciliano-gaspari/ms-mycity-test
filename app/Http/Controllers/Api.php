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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'username' => 'required|string|min:8|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'phone' => 'nullable',
            'password' => 'required|min:10|confirmed',
        ]);
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
    // Visualizza singolo utente via API
    public function show($id)
    {
        $product = User::find($id);
        if (is_null($product)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'L\'utente non è stato trovato',
            ], 200);
        }
        $response = [
            'status' => 'success',
            'message' => 'L\'utente è stato trovato',
            'data' => $product,
        ];
        return response()->json($response, 200);
    }
    // Aggiorna utente via API
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'L\'utente non è stato trovato',
            ], 200);
        }
        $user->update($request->all());
        $response = [
            'status' => 'success',
            'message' => 'L\'utente è stato aggiornato',
            'data' => $user,
        ];
        return response()->json($response, 200);
    }
    // Elimina utente via API
    public function destroy($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'L\'utente non è stato trovato',
            ], 200);
        }
        User::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'L\'utente è stato eliminato',
        ], 200);
    }
}
