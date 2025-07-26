<?php

declare(strict_types=1);

namespace app\Http\Requests\Building;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class BuildingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string|ValidationRule>
     */
    public function rules(): array
    {
        return [
            'min_lat' => 'required|numeric',
            'max_lat' => 'required|numeric',
            'min_lng' => 'required|numeric',
            'max_lng' => 'required|numeric',
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
