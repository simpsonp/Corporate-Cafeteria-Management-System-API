<?php

namespace Tests\Feature;

use App\Models\MealType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTypeControllerTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Test the index method of the MealTypeController.
     *
     * @return void
     */
    public function testIndex()
    {
        // Get meal types from the database
        $mealTypes = MealType::factory()->count(5)->fromPredefinedSubset()->create();

        // Perform a GET request to the index route
        $response = $this->getJson('/api/meals/types');

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert that the response contains the correct JSON structure
        $response->assertJson(function ($json) use ($mealTypes) {
            $mealTypesArray = $mealTypes->mapWithKeys(function ($mealType) {
                return [
                    $mealType->id => [
                        'name' => $mealType->name,
                        'start_time' => $mealType->start_time,
                        'end_time' => $mealType->end_time,
                    ],
                ];
            });

            $json->has('meal_types')
                ->where('meal_types', $mealTypesArray->toArray());
        });
    }
}
