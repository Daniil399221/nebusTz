<?php

declare(strict_types=1);

namespace App\Service\Building;

use App\Models\Building;

class BuildingService
{
    /**
     *  Получаем список всех зданий
     */
    public function getAllBuilding()
    {
        return Building::query()
            ->paginate(15);
    }
}
