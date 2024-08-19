<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MealType::factory()->createFromPredefinedSubset();
    }
}
