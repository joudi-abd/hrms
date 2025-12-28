<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'first_name' => 'required|string|min:2|max:255',       
        'last_name' => 'required|string|min:2|max:255',
        'birth_date' => 'required|date|before:today',
        'phone' => 'required|numeric',
        'address' => 'nullable|string',
        'gender' => 'required|in:male,female',
        'marital_status' => 'nullable|in:single,married,divorced,widowed',
        ];
    }
}
