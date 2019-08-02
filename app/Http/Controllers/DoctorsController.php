<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Patient;

class DoctorsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('roles:admin', ['only' => [
            'destroy',
            'store',
            'index'
        ]]);
    }

    public function index()
    {
        // return User::with('roles')->get();
        return Doctor::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"]
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Validation Failed", "data" => $validator->failed()], 422);
        }

        $email = $request->email;

        $user = User::where("email", $email)->first();


        if (!$user) return response()->json(["status" => "error", "message" => "Error Retrieving User", "data" => null], 400);

        // dd($user->roles()->);
        if ($user->roles()->where('name', 'doctor')->first()) {
            return response()->json(["status" => "error", "message" => "User already has admin privileges", "data" => null], 422);
        }

        $user->roles()->attach(Role::where('name', 'doctor')->first());

        $doctor = Doctor::create(["user_id" => $user->id]);
        return response()->json(["status" => "success", "message" => "User Role Updated Successfully", "data" => $doctor]);
    }

    public function destroy($doctor)
    {
        $doctor = Doctor::findOrFail($doctor);
        $user = $doctor->user;
        // dd($user->roles()->first());
        // Delete the doctor row from 
        $doctor->delete();
        // Detach the doctor priviledge from the user
        // $user = User::where("email", $email)->first();
        $user->roles()->detach(Role::where('name', 'doctor')->first());
        return response()->json(['status' => 'success', 'message' => 'Successfully Deleted Doctor\'s Profile', 'data' => null], 200);
    }

    public function edit(Request $request, $doctor)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Failed Validation', 'data' => $validator->failed()], 422);
        }

        $doctor = Doctor::findOrFail($doctor);
        $doctor = $doctor->update($request->except('user_id'));

        return response()->json(['status' => 'success', 'message' => 'Successfully Updated Doctor\'s Profile', 'data' => $doctor], 200);
    }

    public function allPatients(Request $request, $doctor = null)
    {
        if (!$doctor) $doctor = Doctor::where('user_id', $request->user()->id)->first();
        else $doctor = Doctor::findOrFail($doctor);

        return response()->json(['status' => 'success', 'message' => null, 'data' => $doctor->patients], 200);
    }

    // public function allPatients(Request $request)
    // {
    //     $doctor =  Doctor::FindOrFail($request->user()->id);
    //     return response()->json(['status' => 'success', 'message' => null, 'data' => $doctor->patients], 200);
    // }

    public function addPatient(Request $request, $patient)
    {

        $validator = Validator::make($request->all(), [
            "user_id" => "required"
        ]);

        // Rethink the implementation of this method

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Couldn't complete your request all inputs and try again", "data" => $validator->errors()->all()], 422);
        }

        $patient = Patient::Find($patient);
        if ($patient) { } else {
            // patient does not already exist create the patient and add the patient to the doctor for treatment
            $patient = Patient::create([
                "user_id"
            ]);
            Doctor::where('user_id', $request->user()->id)->first();
        }



        return response()->json(["status" => "", "message" => "some message"]);
    }

    public function addPatientRelative()
    { }
}
