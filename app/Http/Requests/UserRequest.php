<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $userId = $this->input('id');

        return [
            'first_name'       => ['required','string','max:255'],
            'middle_name'      => ['nullable','string','max:255'],
            'last_name'        => ['required','string','max:255'],

            'email'            => [
                'required','email','max:255',
                Rule::unique('users','email')->ignore($userId),
            ],

            'contact_number'   => [
                'required','string','max:15',
                Rule::unique('users','contact_number')->ignore($userId),
            ],
            
            'password'         => [
                $userId ? 'nullable' : 'required',
                'confirmed',
                'min:8',
            ],

            'role'             => ['required','string', Rule::exists('roles','name')],
        ];
    }
}
