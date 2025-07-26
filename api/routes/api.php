<?php

declare(strict_types=1);

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\ApiStaticKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());

Route::middleware(ApiStaticKey::class)->group(function (): void {
    Route::prefix('activity')
        ->controller(ActivityController::class)
        ->group(function (): void {
            Route::get('/', 'index')
                ->name('activity.index');

            Route::get('/{activity}', 'byFindId')
                ->name('activity.byFindId');
        });

    Route::prefix('organization')
        ->controller(OrganizationController::class)
        ->group(function (): void {
            Route::get('/buildings/{building}/organizations', 'getByBuilding')
                ->name('organization.buildings.getByBuilding');

            Route::get('/buildings/{building}/organizations', 'getByBuilding')
                ->name('organization.buildings.getByBuilding');

            Route::get('/activity/{activity}/organizations', 'getByActivity')
                ->name('organization.activity.getByActivity');

            Route::get('/activity/{activity}/organizations-with-children', 'byActivityWithChildren')
                ->name('organization.activity.byActivityWithChildren');

            Route::get('/radius', 'findInRadius')
                ->name('organization.radius.getByRadius');

            Route::get('/search/name', 'searchByName')
                ->name('organization.searchByName');

            Route::get('/{organization}', 'getById')
                ->name('organization.getById');

            Route::get('search/name', 'byFindName')
                ->name('organization.searchByFindName');
        });

    Route::prefix('buildings')
        ->controller(BuildingController::class)
        ->group(function (): void {
            Route::get('/', 'index')
                ->name('buildings.index');

            Route::get('/radius', 'findInRadius')
                ->name('buildings.radius');

            Route::get('/{building}', 'getById')
                ->name('building.getById');
        });
});
