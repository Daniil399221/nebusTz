<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Building\BuildingRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use App\Service\Building\BuildingFindService;
use App\Service\Building\BuildingService;

class BuildingController extends Controller
{

    public function __construct(
       protected BuildingService $service,
       protected BuildingFindService $findService
    ){}

    public function index()
    {
        $data = $this->service->getAllBuilding();

        return response()->json(BuildingResource::collection($data));
    }

    public function getById(Building $building)
    {
        return response()->json($building);
    }

    public function findInRadius(BuildingRequest $request)
    {
        $data = $request->validated();

        $buildings = $this->findService->getFind($data);

        return response()->json($buildings);
    }
}
