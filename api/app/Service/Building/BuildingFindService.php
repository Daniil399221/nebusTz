<?php

declare(strict_types=1);

namespace App\Service\Building;

use App\Models\Building;

class BuildingFindService
{
    /**
     *  Получаем список зданий в выбранном радиусе
     */
    public function getFind(array $data)
    {
        return Building::query()->whereBetween('latitude', [$data['min_lat'], $data['max_lat']])
            ->whereBetween('longitude', [$data['min_lng'], $data['max_lng']])
            ->with(['organization'])
            ->paginate(15);
    }
}
