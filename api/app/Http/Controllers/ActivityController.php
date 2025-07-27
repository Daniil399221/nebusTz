<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Activity\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ActivityController extends Controller
{
    #[OA\Get(
        path: '/api/activity',
        operationId: 'activity.index',
        description: 'Возвращает список деятельностей',
        summary: 'Получить список задач',
        tags: ['Деятельности'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список деятельности',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/ActivityResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
        ],
    )]
    public function index()
    {
        $data = Activity::all();

        return response()->json(ActivityResource::collection($data));
    }

    #[OA\Get(
        path: '/api/activity/{activity}',
        operationId: 'activity.byFindId',
        description: 'Возвращает выбранную деятельность',
        summary: 'Получить деятельность',
        tags: ['Деятельности'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список деятельности',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/ActivityResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
        ],
    )]
    public function byFindId(Activity $activity): JsonResponse
    {
        return response()->json(new ActivityResource($activity));
    }
}
