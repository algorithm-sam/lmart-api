<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return response()->json(['status' => 'success', 'message' => 'Successfully Fetched all user', 'data' => User::all()->except(Auth::user()->id)]);
    }

    public function show()
    {
        return Auth::user();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "filled|min:4"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Failed Validation", "data" => $validator->failed()], 422);
        }

        $user = $request->user()->update($request->except(['id', 'email', 'password']));
        return response()->json(['status' => 'success', 'message' => 'Successfully Updated Your Profile', 'data' => $user]);
    }
}
