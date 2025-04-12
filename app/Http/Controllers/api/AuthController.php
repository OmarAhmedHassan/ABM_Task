<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* Handles user registration*/
    public function register(Request $request)
    {

        $fileds = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $user = User::create($fileds);
        /*
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
*/

        //$data = User::create([$request]);
        //return response()->json($user);
        $token =  $user->createToken($request->name)->plainTextToken;
        //return ['user' => $user, 'token' => $token];
        return response()->json(['user' => $user, 'token' =>   $token]);
    }

    /* Handles user login */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['data' => 'password not correct']);
        }
        $token =  $user->createToken($user->name)->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    /* Logout the user and remove the personal access token.*/
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
