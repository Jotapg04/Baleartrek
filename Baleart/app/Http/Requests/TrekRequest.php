<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrekRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'regNumber'    => 'required|string|unique:treks,regNumber,' . ($this->trek->id ?? ''),
            'name'         => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
        ];
    }
}
