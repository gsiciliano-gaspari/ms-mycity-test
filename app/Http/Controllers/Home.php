<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $userFields = [
            'name' => ['text', 'Nome'],
            'surname' => ['text', 'Cognome'],
            'username' => ['text', 'Username'],
            'email' => ['email', 'Email'],
            'phone' => ['phone', 'Telefono'],
        ];
        $title = 'Benvenuto';
        return view('home', compact('title', 'userFields'));
    }
}
