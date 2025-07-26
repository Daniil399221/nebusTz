<?php

declare(strict_types=1);

namespace App\Service\Organization;

use App\Models\Activity;
use App\Models\Organization;

class ActivityOrganizationService
{
    /**
     *  Получаем список организаций, которые относятся к определенному виду деятельности
     */
    public function getOrganizationsByActivity(Activity $activity)
    {
        return Organization::query()
            ->where('activity_id', $activity->id)
            ->with(['building', 'activity'])
            ->paginate(15);
    }

    /**
     * Получаем список всех организаций, которые относятся к указанному виду деятельности
     * и всем его дочерним видам деятельности (рекурсивно, максимум 3 уровня)
     */
    public function getOrganizationsByActivityWithChildren(Activity $activity)
    {
        $activityIds = $this->getAllChildrenIds($activity->id, 1);
        $activityIds[] = $activity->id;

        return Organization::query()
            ->whereIn('activity_id', $activityIds)
            ->with(['building', 'activity'])
            ->paginate(15);
    }

    /**
     * @return mixed[]
     */
    public function getAllChildrenIds(int $parentId, int $level = 1): array
    {
        // Ограничиваем до 3 уровней вложенности
        if ($level > 3) {
            return [];
        }

        $childIds = [];
        $children = Activity::query()
            ->where('parent_id', $parentId)
            ->select('id')
            ->get();

        foreach ($children as $child) {
            $childIds[] = $child->id;
            $childIds = array_merge($childIds, $this->getAllChildrenIds($child->id, $level + 1));
        }

        return $childIds;
    }
}
