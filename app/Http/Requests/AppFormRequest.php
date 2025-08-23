<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'first_name'                 => ['required','string','max:150'],
            'middle_name'                => ['nullable','string','max:150'],
            'last_name'                  => ['required','string','max:150'],
            'house_number'               => ['required','string','max:150'],
            'street'                     => ['nullable','string','max:150'],
            'city'                     => ['required','string','max:150'],
            'barangay'                => ['required','integer','exists:barangays,id'],
            'years_resident'             => ['required','integer','min:0','max:100'],
            'residence_type'             => ['required','integer','exists:type_residences,id'],
            'birthdate'                 => ['required','date','before:today'],
            'place_of_birth'             => ['required','string','max:150'],
            'gender'                     => ['required','integer','exists:genders,id'],
            'type_id'                    => ['required','integer','exists:type_ids,id'],
            'voters'                     => ['required', Rule::in(['yes','no'])],
            'educational_attainment'     => ['required','integer','exists:educational_attainments,id'],
            'religion'                   => ['required','integer','exists:religions,id'],
            'civil_status'               => ['required','integer','exists:civil_statuses,id'],
            'present_job'                => ['nullable','string','max:150'],
            
            'job_type'                   => ['required','string','max:100'],
            'job'                        => ['required','integer','exists:jobs,id'],
            'sub_job'                    => ['required','integer','exists:sub_jobs,id'],
            'continent'                  => ['required','integer','exists:continents,id'],
            'country'                    => ['required','integer','exists:countries,id'],
            'contract'                   => ['required','integer','exists:contracts,id'],
            'years_abroad'               => ['required','integer','min:0','max:60'],
            'last_departure'             => ['required','date'],
            'last_arrival'               => ['required','date','after_or_equal:date_departure'],
            'owwa'                       => ['nullable','integer','exists:owwas,id'],
            'intent_return'              => ['required', Rule::in(['yes','no'])],
            
            'needs.need_id'              => ['nullable','array'],
            'needs.need_id.*'            => ['nullable','integer','exists:needs,id'],
            
            'household.full_name'        => ['nullable','array'],
            'household.full_name.*'      => ['nullable','string','max:150'],
            'household.relation_id'      => ['nullable','array'],
            'household.relation_id.*'    => ['nullable','integer','exists:relations,id'],
            'household.birthdate'        => ['nullable','array'],
            'household.birthdate.*'      => ['nullable','date','before_or_equal:today'],
            'household.age'              => ['nullable','array'],
            'household.age.*'            => ['nullable','integer','min:0','max:120'],
            'household.work'             => ['nullable','array'],
            'household.work.*'           => ['nullable','string','max:150'],
            'household.monthly_income'   => ['nullable','array'],
            'household.monthly_income.*' => ['nullable','numeric','min:0'],
            'household.voters'           => ['nullable','array'],
            'household.voters.*'         => ['nullable', Rule::in(['yes','no'])],
        ];
    }
}