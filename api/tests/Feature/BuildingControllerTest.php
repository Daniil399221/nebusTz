<?php


use App\Models\Building;

describe('BuildingController', function () {

    test('getBuilding returns all', function () {

        $buildings = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/buildings');

        $response->assertStatus(200);
    });

    test('findInRadius endpoint responds', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/buildings/radius?latitude=55.7558&longitude=37.6176&radius=1000');

        expect($response->status())->not->toBe(404);
    });


    test('getBuilding returns 404 not page', function () {

        $buildings = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/building');

        $response->assertStatus(404);
    });

});
