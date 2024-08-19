<?php

namespace Database\Factories;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return fake()->unique()->randomElement($this->getPredefinedSubset());
    }

    /**
     * Define an array of predefined items.
     *
     * @return array
     */
    public function getPredefinedSubset()
    {
        // Initialize an empty array to store the menus
        $predefinedMenus = [];

        // Start from today
        $currentDate = Carbon::today();

        // Loop through the next 7 days including today
        for ($i = 0; $i < 7; $i++) {
            $menuDate = $currentDate->format('Y-m-d');

            // Loop through meal type IDs 1 to 5
            for ($mealTypeId = 1; $mealTypeId <= 5; $mealTypeId++) {

                // Generate data using the factory
                $predefinedMenus[] = [
                    'menu_date' => $menuDate,
                    'meal_type_id' => $mealTypeId,
                    'item_name' => fake()->sentence(5),
                ];
            }

            // Move to the next day
            $currentDate->addDay();
        }

        // Return the predefined array
        return $predefinedMenus;
    }

    /**
     * Create records of predefined items.
     *
     * @return void
     */
    public function createFromPredefinedSubset()
    {
        // Get the predefined items
        $predefinedMealTypes = $this->getPredefinedSubset();
        // Insert new records or update the existing ones.
        Menu::upsert(
            $predefinedMealTypes,
            ['menu_date', 'meal_type_id'] // Unique constraints for upsert
        );
    }

    /**
     * Define a state for predefined items.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function fromPredefinedSubset()
    {
        // Get the predefined items
        $predefinedMenus = $this->getPredefinedSubset();

        // Return a menu from the predefined array
        return $this->state(function (array $attributes) use ($predefinedMenus) {

            // Get the next item in the array each time the factory is called
            $index = $this->faker->unique()->numberBetween(0, count($predefinedMenus) - 1);

            return $predefinedMenus[$index];
        });
    }
}
