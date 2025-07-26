<?php

declare(strict_types=1);

namespace app\Http\Requests\Organization;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class OrganizationFindNameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string|ValidationRule>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'name.required' => __('Required Field'),
        ];
    }
}
