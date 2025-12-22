<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name'      => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'dni'       => 'required|string|max:10',
            'phone'     => 'required|string|max:15',
            'password'     => 'required|string|max:30',
            'password_confirmation'     => 'required|string|max:30',

        ];
    }
}
