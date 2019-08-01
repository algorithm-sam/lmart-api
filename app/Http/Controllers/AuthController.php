<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
// use App\Models\Token;
use \Firebase\JWT\JWT;
use App\Models\Role;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    public function index()
    {
        return "then";
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validation Failed', 'status' => 'failed'], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid login credential!'], 401);
        }
        $key = env('APP_KEY');

        $token_user = [
            "email" => $user->email,
            "id" => $user->id
        ];

        $token = [
            "iss" => env('APP_URL'),
            "aud" => env('APP_URL'),
            "iat" => time(),
            "nbf" => strtotime('now - 2 minutes'),
            "exp" => strtotime('now + 6 hours'),
            "data" => $token_user
        ];

        $token = JWT::encode($token, $key);


        $user->tokens()->create([
            "token" => $token
        ]);

        // Create the user;
        // Then generate a token for the session and store into the db and return to the client

        return response()->json(["status" => 'success', "token" => $token, 'message' => 'Login Successfully', 'user' => $token_user], 200, ['X-Bearer-Token' => $token]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email", "unique:users"],
            "password" => ["required", "confirmed", "min:8"],
            "name" => ["required", "min:3"]
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        $user->roles()->attach(Role::where('name', 'user')->first());
        // register patient add patient relatives
        // patient 
        $key = env('APP_KEY');

        $token_user = [
            "email" => $user->email,
            "id" => $user->id
        ];

        $token = [
            "iss" => env('APP_URL'),
            "aud" => env('APP_URL'),
            "iat" => time(),
            "nbf" => strtotime('now - 2 minutes'),
            "exp" => strtotime('now + 6 hours'),
            "data" => $token_user
        ];

        $token = JWT::encode($token, $key);


        $user->tokens()->create([
            "token" => $token
        ]);

        // Create the user;
        // Then generate a token for the session and store into the db and return to the client

        return response()->json(["status" => 'success', "token" => $token, 'message' => 'User Created Successfully', 'user' => $token_user], 201, ['X-Bearer-Token' => $token]);
    }

    public function logout(Request $request)
    {
        $token = $request->header('api_token') ? $request->header('api_token') : $request->api_token;
        $deleted = $request->user()->tokens()->where('token', $token)->delete();
        if ($deleted) return response()->json(['status' => 'success', 'message' => 'Logged Out Successfully', 'data' => null], 200);
        return response()->json(['status' => 'error', 'message' => 'Error Logging you out', 'data' => null], 404);
    }

    //
}
