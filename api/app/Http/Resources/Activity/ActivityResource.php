<?php

declare(strict_types=1);

namespace App\Http\Resources\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'ActivityResource',
    properties: [
        new OA\Property(property: 'id', description: 'ID деятельности', type: 'integer', default: 1),
        new OA\Property(property: 'name', description: 'Название деятельности', type: 'string', default: 'Еда'),
        new OA\Property(property: 'parent_id', description: 'ID вида деятельности', type: 'integer', default: 1),
        new OA\Property(property: 'level', description: 'level деятельности', type: 'integer', default: 1),
    ],
    type: 'object',
)]
class ActivityResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'level' => $this->level,
        ];
    }
}
