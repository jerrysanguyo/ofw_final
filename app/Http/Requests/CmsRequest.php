<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $table       = $this->get('cms_table');
        $resourceKey = $this->get('resource');
        $model       = $this->route($resourceKey);
        $id          = $model?->getKey();   

        $rules = [
            'name'    => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')->ignore($id),
            ],
            'remarks' => ['nullable', 'string',  'max:' . ($table === 'learning_domains' ? 5000 : 255)],
        ];
        
        return array_merge($rules, $this->getAdditionalRulesForTable($table));
    }
    
    protected function getAdditionalRulesForTable(?string $table): array
    {
        return match ($table) {
            'countries' => [
                'continent_id' => ['required', 'numeric', 'exists:continents,id'],
            ],
            'sub_jobs' => [
                'job_id' => ['required', 'numeric', 'exists:jobs,id'],
            ],
            default => [],
        };
    }
}
