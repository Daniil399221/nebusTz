<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Building\BuildingRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index()
    {
        $data = Building::all();

        return response()->json(BuildingResource::collection($data));
    }

    public function getById(Building $building)
    {
        return response()->json($building);
    }

    public function findInRadius(BuildingRequest $request)
    {
        $data = $request->validated();

        $buildings = Building::query()->whereBetween('latitude', [$data['min_lat'], $data['max_lat']])
            ->whereBetween('longitude', [$data['min_lng'], $data['max_lng']])
            ->with(['organization'])
            ->paginate(15);

        return response()->json($buildings);
    }
}
