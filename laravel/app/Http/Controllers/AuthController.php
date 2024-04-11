<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);
        try {
            $user = new User([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->save();
            $userToken = $user->createToken('authToken')->plainTextToken;
            $user->user_token = $userToken;
            $user->save();
            return response()->json([
                'user' => $user,
                'token' => $userToken,
                'message' => 'User registered successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User registration failed.'], 500);
        }
    }
    public function getUser(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $decryptedId = Crypt::decrypt($token);
            $user = User::whereHas('tokens', function ($query) use ($decryptedId) {
                $query->where('token', $decryptedId);
            })->first();
            if ($user) {
                return response()->json([
                    'user' => $user,
                ], 200);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
// $token = $user->createToken('authToken')->plainTextToken;
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = encrypt($user->id);
            return response()->json([
                'user' => $user,
                'token' => $token,
                'redirect' => '/'
            ], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
