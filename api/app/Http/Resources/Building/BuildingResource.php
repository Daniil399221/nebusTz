<?php

declare(strict_types=1);

namespace App\Http\Resources\Building;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'BuildingResource',
    properties: [
        new OA\Property(property: 'id', description: 'ID здания', type: 'integer', default: 1),
        new OA\Property(property: 'address', description: 'Адресс здания', type: 'string', default: 'г. Казань, ул. Баумана 15'),
        new OA\Property(property: 'latitude', description: 'Широта', type: 'float', default: '55.3123'),
        new OA\Property(property: 'longitude', description: 'Долгота', type: 'float', default: '48.3123'),
    ],
    type: 'object',
)]
class BuildingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
