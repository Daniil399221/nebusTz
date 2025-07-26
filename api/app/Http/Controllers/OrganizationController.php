<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Organization\OrganizationFindNameRequest;
use App\Http\Requests\Organization\OrganizationRadiusRequest;
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

    public function getById(Organization $organization)
    {
        return response()->json($organization);
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

    public function findInRadius(OrganizationRadiusRequest $request)
    {
        $data = $request->validated();

        $organizations = Organization::query()->join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->whereBetween('buildings.latitude', [$data['min_lat'], $data['max_lat']])
            ->whereBetween('buildings.longitude', [$data['min_lng'], $data['max_lng']])
            ->with(['building', 'activity'])
            ->paginate(15);

        return response()->json($organizations);
    }

    public function byFindName(OrganizationFindNameRequest $request)
    {
        $data = $request->validated();

        $organizations = Organization::query()
            ->where('name', 'like', '%' . $data['name'] . '%')
            ->with(['building', 'activity'])
            ->paginate(15);

        return response()->json($organizations);
    }
}
