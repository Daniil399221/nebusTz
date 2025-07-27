<?php

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;

describe('OrganizationController', function () {
    
    test('getByBuilding returns organizations for building', function () {
        $building = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);
        
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);
        
        $organization = Organization::create([
            'name' => 'Test Organization',
            'phone' => '+1234567890',
            'building_id' => $building->id,
            'activity_id' => $activity->id,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get("/api/organization/buildings/{$building->id}/organizations");

        $response->assertStatus(200);
    });

    test('getById returns organization details', function () {
        $building = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);
        
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);
        
        $organization = Organization::create([
            'name' => 'Test Organization',
            'phone' => '+1234567890',
            'building_id' => $building->id,
            'activity_id' => $activity->id,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get("/api/organization/{$organization->id}");

        $response->assertStatus(200);
    });

    test('getByActivity returns organizations for activity', function () {
        $building = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);
        
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);
        
        $organization = Organization::create([
            'name' => 'Test Organization',
            'phone' => '+1234567890',
            'building_id' => $building->id,
            'activity_id' => $activity->id,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get("/api/organization/activity/{$activity->id}/organizations");

        $response->assertStatus(200);
    });

    test('byActivityWithChildren returns organizations with children activities', function () {
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get("/api/organization/activity/{$activity->id}/organizations-with-children");

        $response->assertStatus(200);
    });

    test('findInRadius endpoint responds', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/radius?latitude=55.7558&longitude=37.6176&radius=1000');

        expect($response->status())->not->toBe(404);
    });

    test('byFindName returns organizations by name search', function () {
        $building = Building::create([
            'address' => 'Test Address',
            'latitude' => 55.7558,
            'longitude' => 37.6176,
        ]);
        
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);
        
        $organization = Organization::create([
            'name' => 'Test Organization',
            'phone' => '+1234567890',
            'building_id' => $building->id,
            'activity_id' => $activity->id,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/search/name?name=' . urlencode($organization->name));

        $response->assertStatus(200);
    });

    test('byFindName returns 422 without name parameter', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/search/name');

        $response->assertStatus(422);
    });

    test('returns 404 for non-existent building', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/buildings/99999/organizations');

        $response->assertStatus(404);
    });

    test('returns 404 for non-existent organization', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/99999');

        $response->assertStatus(404);
    });

    test('returns 404 for non-existent activity', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/organization/activity/99999/organizations');

        $response->assertStatus(404);
    });
}); 