<?php

namespace App\Http\Controllers;

use App\Http\Resources\Organization\OrganizationActivityResource;
use App\Http\Resources\Organization\OrganizationBuildingResource;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Service\ActivityOrganizationService;

class OrganizationController extends Controller
{
    public function __construct(
        protected ActivityOrganizationService $service,
    ) {}


    public function getByBuilding(Building $building)
    {
        $organizations = Organization::query()
            ->where('building_id', $building->id)
            ->with(['building', 'activity'])
            ->paginate(15);

        return response(OrganizationBuildingResource::collection($organizations));

    }

    public function getByActivity(Activity $activity)
    {
        $activities = $this->service->getOrganizationsByActivity($activity);
        return response(OrganizationActivityResource::collection($activities));
    }


    public function byActivityWithChildren(Activity $activity)
    {
        $organizations = $this->service->getOrganizationsByActivityWithChildren($activity);
        return response()->json($organizations);
    }
}
