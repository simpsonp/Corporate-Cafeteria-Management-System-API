<?php

namespace Tests\Feature;

use App\Models\MealType;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuControllerTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Populate the database with initial data
        MealType::factory()->createFromPredefinedSubset();
    }

    /**
     * Test the index method of the MenuController.
     *
     * @return void
     */
    public function testIndex()
    {
        // Populate the database with some data
        Menu::factory()->count(10)->fromPredefinedSubset()->create();

        // Get the current date (start of today)
        $startDate = Carbon::today()->format('Y-m-d');

        // Get the date 7 days from now to represent the end of the week
        $endDate = Carbon::today()->addDays(7)->format('Y-m-d');

        // Perform a GET request to the index route
        $response = $this->getJson('/api/menus');

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert that the response contains the correct JSON structure
        $response->assertJson(function ($json) use ($startDate, $endDate) {
            $json->has('menus')
                ->where('menus', function ($menus) use ($startDate, $endDate) {
                    // Check that all menus fall within the correct date range
                    foreach ($menus as $date => $mealTypes) {
                        $this->assertGreaterThanOrEqual($startDate, $date);
                        $this->assertLessThanOrEqual($endDate, $date);
                        foreach ($mealTypes as $mealTypeId => $attributes) {
                            $this->assertArrayHasKey('item_name', $attributes);
                        }
                    }
                    return true;
                });
        });
    }
}
