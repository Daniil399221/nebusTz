<?php

declare(strict_types=1);

namespace App\Service\Organization;

use App\Models\Organization;

class OrganizationFindService
{
    /**
     *  Поиск организации по заданному радиусу в прямоугольнике
     */
    public function getFindOrganizationsInRadius(array $data)
    {
        return Organization::query()->join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->whereBetween('buildings.latitude', [$data['min_lat'], $data['max_lat']])
            ->whereBetween('buildings.longitude', [$data['min_lng'], $data['max_lng']])
            ->with(['building', 'activity'])
            ->paginate(15);
    }

    /**
     * Поиск организации по названию
     */
    public function getFindOrganizationsInName(array $data)
    {
        return Organization::query()
            ->where('name', 'like', '%' . $data['name'] . '%')
            ->with(['building', 'activity'])
            ->paginate(15);
    }
}
