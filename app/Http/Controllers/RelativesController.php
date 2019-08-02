<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Relative;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use App\User;

class RelativesController extends Controller
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

    public function store(Request $request, $patient)
    {
        // figure out what data to store for the relative;
        //get the patients of the doctor who is making the request...
        // then check if the patient id specified is one in which he is the doctor;

        $validator = Validator::make($request->all(), [
            'relatives_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => null], 422);
        }

        $user = User::where('email', $request->relatives_email)->first();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Error Fetching the specified user, check the email and retry', 'data' => null], 400);
        $doctor = Doctor::where('user_id', $request->user()->id)->first();
        $patient = $doctor->patients()->where('patient_id', $patient)->first();

        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Oops that is not your patient.... Please register the patient as your patient then try again', 'data' => null], 422);
        }

        $relative = Relative::create(['user_id' => $user->id]);
        // Create new Relative Instance
        if (!$relative) return response()->json(['status' => 'error', 'message' => 'Could not Create Relative\'s Profile'], 422);
        $patient->relatives()->attach($relative);
        return response()->json(['status' => 'success', 'message' => null, 'data' => $patient->relatives], 200);
    }

    public function all(Request $request, $patient)
    {
        $doctor = Doctor::where('user_id', $request->user()->id)->first();
        $patient = $doctor->patients()->where('patient_id', $patient)->first();


        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Oops Error Occured, Check the email and try again... You may have to register the patient as your patient first if you haven\'t already', 'data' => null], 422);
        }

        return response()->json(['status' => 'success', 'message' => 'Fetched Patients Relatives', 'data' => $patient->relatives]);
    }
    //
}
