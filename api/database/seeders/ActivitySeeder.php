<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level 1

        $food = Activity::query()->firstOrCreate(['name' => 'Еда'], [
            'name' => 'Еда',
            'parent_id' => null,
            'level' => 1,
        ]);

        $cars = Activity::query()->firstOrCreate(['name' => 'Автомобили'], [
            'name' => 'Автомобили',
            'parent_id' => null,
            'level' => 1,
        ]);

        $passengerCars = Activity::query()->firstOrCreate(['name' => 'Легковые автомобили'], [
            'name' => 'Легковые автомобили',
            'parent_id' => null,
            'level' => 1,
        ]);

        // Level 2

        Activity::query()->firstOrCreate(['name' => 'Мясная продукция'], [
            'name' => 'Мясная продукция',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        Activity::query()->firstOrCreate(['name' => 'Молочная продукция'], [
            'name' => 'Молочная продукция',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        Activity::query()->firstOrCreate(['name' => 'Грузовые'], [
            'name' => 'Грузовые',
            'parent_id' => $cars->id,
            'level' => 2,
        ]);

        Activity::query()->firstOrCreate(['name' => 'Запчасти'], [
            'name' => 'Запчасти',
            'parent_id' => $passengerCars->id,
            'level' => 2,
        ]);

        Activity::query()->firstOrCreate(['name' => 'Аксессуары'], [
            'name' => 'Аксессуары',
            'parent_id' => $passengerCars->id,
            'level' => 2,
        ]);

        // Level 3

        $this->createLevel3Activities($food->id, [
            'Свинина', 'Курица', 'Баранина',
        ]);

        $this->createLevel3Activities($food->id, [
            'Йогурт', 'Молоко', 'Кефир',
        ]);

        $this->createLevel3Activities($cars->id, [
            'Тягач', 'Автовышка', 'Самосвалы',
        ]);

        $this->createLevel3Activities($passengerCars->id, [
            'Бампер', 'Копот', 'Спойлер',
        ]);

        $this->createLevel3Activities($passengerCars->id, [
            'Брелки', 'Модельки', 'Пахнючки',
        ]);
    }

    private function createLevel3Activities(int $parentId, array $names): void
    {
        foreach ($names as $name) {
            Activity::query()->firstOrCreate(['name' => $name], [
                'parent_id' => $parentId,
                'level' => 3,
            ]);
        }
    }
}
