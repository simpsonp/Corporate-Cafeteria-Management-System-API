<?php

namespace App\Http\Controllers;

use App\Models\MealType;

class MealTypeController extends Controller
{
    /**
     * Display a listing of meal types.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all meal type records from the database
        $mealTypes = MealType::all();

        // Transform the collection into an array of meal types
        // with the meal type ID as the key and an array of attributes as the value
        $mealTypesArray = $mealTypes->mapWithKeys(function ($mealType) {
            return [
                $mealType->id => [
                    'name' => $mealType->name,
                    'start_time' => $mealType->start_time,
                    'end_time' => $mealType->end_time,
                ],
            ];
        });

        // Return the array of meal types as a JSON response
        return response()->json(['meal_types' => $mealTypesArray]);
    }
}
