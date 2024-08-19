<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the current logged-in user.
     */
    public function showCurrent(Request $request)
    {
        $user = $request->user();
        $userDetails = [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
        ];
        return response()->json(['user' => $userDetails]);
    }
}
