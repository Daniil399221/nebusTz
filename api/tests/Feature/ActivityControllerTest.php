<?php


use App\Models\Activity;


describe('ActivityController', function () {

    test('getActivity returns all', function () {

        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/activity');

        $response->assertStatus(200);
    });


    test('getById returns activity details', function () {
        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get("/api/activity/{$activity->id}");

        $response->assertStatus(200);
    });

    test('returns 404 for non-existent activity', function () {
        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/activity/99999');

        $response->assertStatus(404);
    });

    test('getActivity returns 404 not page', function () {

        $activity = Activity::create([
            'name' => 'Test Activity',
            'parent_id' => null,
            'level' => 1,
        ]);

        $response = $this->withHeaders([
            'api-static-key' => 'fa30-k4v9-5316-kEQ'
        ])->get('/api/activities');

        $response->assertStatus(404);
    });

});
