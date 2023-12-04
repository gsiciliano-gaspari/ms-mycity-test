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
        return [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'phone' => 'nullable',
            'password' => 'required|min:10|confirmed',
            'roles' => 'required'
        ];
    }
}
