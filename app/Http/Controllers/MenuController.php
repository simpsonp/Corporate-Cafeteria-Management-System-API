<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Carbon\Carbon;

class MenuController extends Controller
{
    /**
     * Display a listing of menus for the upcoming week.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get the current date (start of today)
        $startDate = Carbon::today()->format('Y-m-d');

        // Get the date 7 days from now to represent the end of the week
        $endDate = Carbon::today()->addDays(7)->format('Y-m-d');

        // Initialize an empty array to store the menus
        $menus = [];

        // Fetch all menu records where the menu_date is between the start date and end date
        // This means we are getting all the menus for the upcoming week
        $menuRecords = Menu::whereBetween('menu_date', [$startDate, $endDate])->get();

        // Iterate over each menu record retrieved from the database
        foreach ($menuRecords as $menu) {
            // Organize the menus array by date and meal type
            // The item name is stored for each meal type on a particular date
            $menus[$menu->menu_date][$menu->meal_type_id] = [
                'item_name' => $menu->item_name,
            ];
        }

        // Return the organized menus as a JSON response
        return response()->json(['menus' => $menus]);
    }
}
