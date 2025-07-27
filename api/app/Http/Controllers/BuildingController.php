<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Building\BuildingRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use App\Service\Building\BuildingFindService;
use App\Service\Building\BuildingService;
use OpenApi\Attributes as OA;

class BuildingController extends Controller
{
    public function __construct(
        protected BuildingService $service,
        protected BuildingFindService $findService,
    ) {}

    #[OA\Get(
        path: '/api/buildings',
        operationId: 'buildings.index',
        description: 'Возвращает список зданий',
        summary: 'Получить список зданий',
        tags: ['Здания'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список зданий',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/BuildingResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
        ],
    )]
    public function index()
    {
        $data = $this->service->getAllBuilding();

        return response()->json(BuildingResource::collection($data));
    }

    #[OA\Get(
        path: '/api/building/{building}',
        operationId: 'building.getById',
        description: 'Возвращает выбранное здание',
        summary: 'Получить здание',
        tags: ['Здания'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список зданий',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/BuildingResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
        ],
    )]
    public function getById(Building $building)
    {
        return response()->json(new BuildingResource($building));
    }

    #[OA\Get(
        path: '/api/buildings/radius',
        operationId: 'buildings.radius',
        description: 'Поиск зданий в заданном географическом радиусе по координатам',
        summary: 'Найти здания в радиусе',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/BuildingRequest'),
        ),
        tags: ['Здания'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список зданий в заданном радиусе',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/BuildingResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Ошибка валидации',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ],
                ),
            ),
        ],
    )]
    public function findInRadius(BuildingRequest $request)
    {
        $data = $request->validated();

        $buildings = $this->findService->getFind($data);

        return response()->json($buildings);
    }
}
