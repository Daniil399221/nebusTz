<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Activity\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function index()
    {
        $data = Activity::all();

        return response()->json(ActivityResource::collection($data));
    }

    public function byFindId(Activity $activity): JsonResponse
    {
        return response()->json($activity);
    }
}
