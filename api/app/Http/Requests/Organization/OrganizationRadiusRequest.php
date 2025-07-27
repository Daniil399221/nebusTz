<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'OrganizationRadiusRequest',
    title: 'Organization Radius Request',
    description: 'Запрос для поиска зданий в радиусе',
    properties: [
        new OA\Property(property: 'min_lat', description: 'Минимальная широта', type: 'number', format: 'float', default: '50.000'),
        new OA\Property(property: 'max_lat', description: 'Максимальная широта', type: 'number', format: 'float', default: '60.000'),
        new OA\Property(property: 'min_lng', description: 'Минимальная долгота', type: 'number', format: 'float', default: '40.000'),
        new OA\Property(property: 'max_lng', description: 'Максимальная долгота', type: 'number', format: 'float', default: '50.000'),
    ],
)]
class OrganizationRadiusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string|ValidationRule>
     */
    public function rules(): array
    {
        return [
            'min_lat' => ['required', 'numeric'],
            'max_lat' => ['required', 'numeric'],
            'min_lng' => ['required', 'numeric'],
            'max_lng' => ['required', 'numeric'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'min_lat.required' => __('Required Field'),
            'max_lat.required' => __('Required Field'),
            'min_lng.required' => __('Required Field'),
            'max_lng.required' => __('Required Field'),
        ];
    }
}
