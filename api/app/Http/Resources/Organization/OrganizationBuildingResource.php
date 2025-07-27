<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\Building\BuildingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'OrganizationBuildingResource',
    title: 'Organization Building Resource',
    description: 'Ресурс организации с информацией о здании и деятельности',
    properties: [
        new OA\Property(property: 'id', description: 'Уникальный идентификатор организации', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', description: 'Название организации', type: 'string'),
        new OA\Property(property: 'slug', description: 'URL-friendly название организации', type: 'string'),
        new OA\Property(property: 'phone', description: 'Контактный телефон организации', type: 'string'),
        new OA\Property(
            property: 'activity',
            ref: '#/components/schemas/ActivityResource',
            description: 'Информация о виде деятельности',
            type: 'object',
            nullable: true,
        ),
        new OA\Property(
            property: 'building',
            ref: '#/components/schemas/BuildingResource',
            description: 'Информация о здании',
            type: 'object',
            nullable: true,
        ),
    ],
)]
class OrganizationBuildingResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'activity' => $this->whenLoaded('activity', fn(): ActivityResource => new ActivityResource($this->activity)),
            'building' => $this->whenLoaded('building', fn(): BuildingResource => new BuildingResource($this->building)),
        ];
    }
}
