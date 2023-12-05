<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'username' => 'required|string|min:8|max:20|unique:users,username,' . $user->id,
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'password' => 'required|min:10|confirmed',
            'roles' => 'required'
        ];
    }
}
