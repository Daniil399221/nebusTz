<?php

namespace App\Service;

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
     * и всем его дочерним видам деятельности (рекурсивно)
     */
    public function getOrganizationsByActivityWithChildren(Activity $activity)
    {
        $activityIds = $this->getAllChildrenIds($activity->id);
        $activityIds[] = $activity->id;

        return Organization::query()->whereHas('activity', function ($query) use ($activityIds) {
            $query->whereIn('activity_id', $activityIds);
                 })->with(['building', 'activity'])->get();
    }

    public function getAllChildrenIds(int $parentId)
    {
        $childIds = [];
        $children = Activity::query()->where('parent_id', $parentId)->get();

        foreach ($children as $child) {
            $childIds[] = $child->id;
            $childIds = array_merge($childIds, $this->getAllChildrenIds($child->id));
        }

        return $childIds;
    }



}
