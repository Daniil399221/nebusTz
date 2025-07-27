<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'OrganizationFindNameRequest',
    title: 'Organization Find Name Request',
    description: 'Запрос для поиска зданий в радиусе',
    properties: [
        new OA\Property(property: 'name', description: 'Название здания', type: 'string', default: 'Ankunding and Sons'),
    ],
)]
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
            'name' => ['required', 'string'],
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
