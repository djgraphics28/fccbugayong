<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (! $user) {
            return response()->json(['message' => 'If that email exists, a reset link has been sent.'], 200);
        }

        // Create a simple token and store as password_reset in users table or send via mail. Minimal approach: use built-in password broker
        $status = \Password::sendResetLink(['email' => $fields['email']]);

        if ($status === \Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent.'], 200);
        }

        return response()->json(['message' => 'Unable to send reset link.'], 500);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            // Revoke current token
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logged out'], 200);
    }
}

