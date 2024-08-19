<?php

namespace Database\Factories;

use App\Models\MealType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = MealType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, int>
     */
    public function definition()
    {
        // Generate start_time
        $startTime = $this->faker->time();
        // Convert start_time to a Carbon instance for manipulation
        $start = Carbon::createFromFormat('H:i:s', $startTime);
        // Add a fixed interval (e.g., 2 hours) to get end_time
        $end = $start->copy()->addHours(2);

        return [
            'name' => $this->faker->randomElement([
                'Breakfast',
                'Lunch',
                'Evening Tea',
                'Dinner',
                'Midnight Snack',
            ]),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
        ];
    }

    /**
     * Define an array of predefined items.
     *
     * @return array
     */
    public function getPredefinedSubset()
    {
        // Define an array of sample meal types with associated data
        $predefinedMealTypes = [
            [
                'id' => 1,
                'name' => 'Breakfast',
                'start_time' => '06:00:00',
                'end_time' => '08:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Lunch',
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Evening Tea',
                'start_time' => '17:00:00',
                'end_time' => '17:30:00',
            ],
            [
                'id' => 4,
                'name' => 'Dinner',
                'start_time' => '21:00:00',
                'end_time' => '23:00:00',
            ],
            [
                'id' => 5,
                'name' => 'Midnight Snack',
                'start_time' => '23:59:00',
                'end_time' => '03:00:00',
            ],
        ];

        // Return a meal type from the predefined array
        return $predefinedMealTypes;
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
        MealType::upsert(
            $predefinedMealTypes,
            ['id']
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
        $predefinedMealTypes = $this->getPredefinedSubset();

        // Return a meal type from the predefined array
        return $this->state(function (array $attributes) use ($predefinedMealTypes) {

            // Get the next item in the array each time the factory is called
            $index = $this->faker->unique()->numberBetween(0, count($predefinedMealTypes) - 1);

            return $predefinedMealTypes[$index];
        });
    }
}
