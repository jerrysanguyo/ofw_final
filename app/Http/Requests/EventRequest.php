<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'date'  =>  'required|date|before:now',
            'time'  => 'required|string',
            'barangay'   => 'required|integer|exists:barangays,id',
            'venue' =>  'required|string|max:255',
            'remarks'   => 'nullable|max:255',
            'status'    => 'sometimes|in:created,ongoing,done'
        ];
    }
}
