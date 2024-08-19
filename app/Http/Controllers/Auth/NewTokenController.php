<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class NewTokenController extends Controller
{
    /**
     * Handle an incoming new token request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token_name = $request->token_name;

        // Revoke the existing token with same name, if any
        $user->tokens()->where('name', $token_name)->delete();

        $plainTextToken = $user->createToken($token_name)->plainTextToken;

        return response()->json(['token' => $plainTextToken]);
    }
}
