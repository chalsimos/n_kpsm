<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponses;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function checkmail(Request $request)
{
    $email = $request->input('email');
    $exists = User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
}

public function register(Request $request)
{
    try {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:0',
            'birthday' => 'required|date',
            'contactnumber' => 'required|integer',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ]);
        $district = $this->getDistrict($validatedData['municipality']);
        $user = new User([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'gender' => $validatedData['gender'],
            'age' => $validatedData['age'],
            'birthday' => $validatedData['birthday'],
            'contactnumber' => $validatedData['contactnumber'],
            'province' => $validatedData['province'],
            'municipality' => $validatedData['municipality'],
            'barangay' => $validatedData['barangay'],
            'type' => 'client',
            'district' => $district,
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
        Log::error('User registration failed: ' . $e->getMessage());
        return response()->json(['message' => 'User registration failed.'], 500);
    }
}
public function registerAdmin(Request $request)
{
    try {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:0',
            'birthday' => 'required|date',
            'contactnumber' => 'required|integer',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ]);
        $district = $this->getDistrict($validatedData['municipality']);
        $user = new User([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'gender' => $validatedData['gender'],
            'age' => $validatedData['age'],
            'birthday' => $validatedData['birthday'],
            'contactnumber' => $validatedData['contactnumber'],
            'province' => $validatedData['province'],
            'municipality' => $validatedData['municipality'],
            'barangay' => $validatedData['barangay'],
            'type' => 'admin',
            'district' => $district,
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
        Log::error('User registration failed: ' . $e->getMessage());
        return response()->json(['message' => 'User registration failed.'], 500);
    }
}
public function registerSuperAdmin(Request $request)
{
    try {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:0',
            'birthday' => 'required|date',
            'contactnumber' => 'required|integer',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ]);
        $district = $this->getDistrict($validatedData['municipality']);
        $user = new User([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'gender' => $validatedData['gender'],
            'age' => $validatedData['age'],
            'birthday' => $validatedData['birthday'],
            'contactnumber' => $validatedData['contactnumber'],
            'province' => $validatedData['province'],
            'municipality' => $validatedData['municipality'],
            'barangay' => $validatedData['barangay'],
            'type' => 'superadmin',
            'district' => $district,
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
        Log::error('User registration failed: ' . $e->getMessage());
        return response()->json(['message' => 'User registration failed.'], 500);
    }
}

private function getDistrict($municipality)
{
    $firstDistrictMunicipalities = [
        'Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria'
    ];
    $secondDistrictMunicipalities = [
        'Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas'
    ];
    if (in_array($municipality, $firstDistrictMunicipalities)) {
        return '1st';
    } elseif (in_array($municipality, $secondDistrictMunicipalities)) {
        return '2nd';
    } else {
        return $municipality;
     }
}

    public function getUser(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $decryptedId = Crypt::decrypt($token);
            // $user = User::whereHas('tokens', function ($query) use ($decryptedId) {
            //     $query->where('token', $decryptedId);
            // })->first();
            $user = User::find($decryptedId); //ito muna sir ginamit ko diko mapagana yung sa inyo
            if ($user) {
                return response()->json([
                    'user' => $user,
                ], 200);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function getUserType(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $decryptedId = Crypt::decrypt($token);
            $user = User::find($decryptedId);
            if ($user) {
                return response()->json([
                    'type' => $user->type,
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
