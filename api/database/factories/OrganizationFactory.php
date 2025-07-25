<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'building_id' => Building::all()->random()->id,
            'phone' => '+7' . fake()->unique()->numerify('(9##)#######'),
            'activity_id' => Activity::where('level', 1)->get()->random()->id,
        ];
    }
}
