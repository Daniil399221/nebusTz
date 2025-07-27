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
use App\Service\Organization\ActivityOrganizationService;
use App\Service\Organization\OrganizationFindService;
use OpenApi\Attributes as OA;

class OrganizationController extends Controller
{
    public function __construct(
        protected ActivityOrganizationService $service,
        protected OrganizationFindService $findService,
    ) {}

    #[OA\Get(
        path: '/api/organization/buildings/{building}/organizations',
        operationId: 'organization.buildings.getByBuilding',
        description: 'Получение списка всех организаций, расположенных в конкретном здании',
        summary: 'Получить организации по зданию',
        tags: ['Организации'],
        parameters: [
            new OA\Parameter(
                name: 'building',
                description: 'ID здания',
                in: 'path',
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций в здании',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OrganizationBuildingResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Здание не найдено',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Здание не найдено'),
                    ],
                ),
            ),
        ],
    )]
    public function getByBuilding(Building $building)
    {
        $organizations = Organization::query()
            ->where('building_id', $building->id)
            ->with(['building', 'activity'])
            ->paginate(15);

        return response(OrganizationBuildingResource::collection($organizations));
    }

    #[OA\Get(
        path: '/api/organization/{organization}',
        operationId: 'organization.getById',
        description: 'Получение детальной информации о конкретной организации',
        summary: 'Получить организацию по ID',
        tags: ['Организации'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Детальная информация об организации',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OrganizationBuildingResource'),
                        ),
                    ],
                    type: 'object',
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Организация не найдена',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Организация не найдена'),
                    ],
                ),
            ),
        ],
    )]
    public function getById(Organization $organization)
    {
        $organization->load(['building', 'activity']);

        return response()->json(new OrganizationBuildingResource($organization));
    }

    #[OA\Get(
        path: '/api/organization/activity/{activity}/organizations',
        operationId: 'organization.activity.getByActivity',
        description: 'Получение списка организаций по конкретному виду деятельности',
        summary: 'Получить организации по виду деятельности',
        tags: ['Организации'],
        parameters: [
            new OA\Parameter(
                name: 'activity',
                description: 'ID вида деятельности',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций по виду деятельности',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OrganizationActivityResource'),
                        ),
                        new OA\Property(
                            property: 'meta',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ],
                            type: 'object',
                        ),
                    ],
                    type: 'object',
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Вид деятельности не найден',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Вид деятельности не найден'),
                    ],
                ),
            ),
        ],
    )]
    public function getByActivity(Activity $activity)
    {
        $activities = $this->service->getOrganizationsByActivity($activity);

        return response(OrganizationActivityResource::collection($activities));
    }

    #[OA\Get(
        path: '/api/organization/activity/{activity}/organizations-with-children',
        operationId: 'organization.activity.byActivityWithChildren',
        description: 'Получение организаций по виду деятельности включая все дочерние категории (до 3 уровней вложенности)',
        summary: 'Получить организации с дочерними категориями',
        tags: ['Организации'],
        parameters: [
            new OA\Parameter(
                name: 'activity',
                description: 'ID вида деятельности',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций с дочерними категориями',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'string', format: 'uuid'),
                                    new OA\Property(property: 'name', type: 'string'),
                                    new OA\Property(property: 'slug', type: 'string'),
                                    new OA\Property(property: 'phone', type: 'string'),
                                    new OA\Property(property: 'activity_id', type: 'integer'),
                                    new OA\Property(property: 'building_id', type: 'integer'),
                                    new OA\Property(
                                        property: 'building',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'integer'),
                                            new OA\Property(property: 'address', type: 'string'),
                                            new OA\Property(property: 'latitude', type: 'number', format: 'float'),
                                            new OA\Property(property: 'longitude', type: 'number', format: 'float'),
                                        ],
                                        type: 'object',
                                    ),
                                    new OA\Property(
                                        property: 'activity',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'integer'),
                                            new OA\Property(property: 'name', type: 'string'),
                                            new OA\Property(property: 'parent_id', type: 'id'),
                                            new OA\Property(property: 'level', type: 'id'),
                                        ],
                                        type: 'object',
                                    ),
                                ],
                            ),
                        ),
                        new OA\Property(
                            property: 'meta',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ],
                            type: 'object',
                        ),
                    ],
                    type: 'object',
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Вид деятельности не найден',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Вид деятельности не найден'),
                    ],
                ),
            ),
        ],
    )]
    public function byActivityWithChildren(Activity $activity)
    {
        $organizations = $this->service->getOrganizationsByActivityWithChildren($activity);

        return response()->json($organizations);
    }

    #[OA\Get(
        path: '/api/organization/radius',
        operationId: 'organization.radius.getByRadius',
        description: 'Поиск организаций в заданном географическом радиусе по координатам',
        summary: 'Найти организации в радиусе',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OrganizationRadiusRequest'),
        ),
        tags: ['Организации'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций в заданном радиусе',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OrganizationBuildingResource'),
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
    public function findInRadius(OrganizationRadiusRequest $request)
    {
        $data = $request->validated();

        $organizations = $this->findService->getFindOrganizationsInRadius($data);

        return response(OrganizationBuildingResource::collection($organizations));
    }

    #[OA\Get(
        path: '/api/organization/search/name',
        operationId: 'organization.searchByFindName',
        description: 'Поиск организаций по названию с использованием частичного совпадения',
        summary: 'Найти организации по названию',
        tags: ['Организации'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                description: 'Название организации для поиска',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций по названию',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OrganizationBuildingResource'),
                        ),
                        new OA\Property(
                            property: 'meta',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ],
                            type: 'object',
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
    public function byFindName(OrganizationFindNameRequest $request)
    {
        $data = $request->validated();

        $organizations = $this->findService->getFindOrganizationsInName($data);

        return response(OrganizationBuildingResource::collection($organizations));
    }
}
