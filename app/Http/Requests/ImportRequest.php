<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'import_file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:20480',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'import_file.required' => 'Please choose a file to upload.',
            'import_file.mimes'    => 'Allowed formats: .xlsx, .xls, .csv',
            'import_file.max'      => 'The file size must not exceed 20MB.',
        ];
    }
}