<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class PatientsController extends Controller
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


    public function all()
    {
        return Patient::all();
    }

    public function getRelatives(Request $request, Patient $patient)
    {
        return $patient->relative();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email"
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Email is Required", "data" => null], 400);
        }

        $doctor = Doctor::where('user_id', $request->user()->id)->first();
        $user = User::where('email', $request->email)->first();
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$user) {
            return response()->json(["status" => "error", "message" => "Error Fetching Specified User", "data" => null], 404);
        }

        if (!$patient) {
            $patient = Patient::create(['user_id' => $user->id]);
            $doctor->patients()->attach($patient);
            return response()->json(['status' => 'success', 'message' => 'Successfully Admitted New Patient', 'data' => $patient], 201);
        }

        $hasMeAsDoctor = $patient->doctors()->where('doctor_id', $request->user()->id)->first();
        if ($hasMeAsDoctor) {
            return response()->json(['status' => 'info', 'message' => 'Patient Has Once Been Registered Under Your Care. No Need To Re-Register, Proceed With Treatment'], 200);
        } else {
            $doctor->patients()->attach($patient);
            return response()->json(['status' => 'success', 'message' => 'Successfully Admitted New Patient', 'data' => $patient], 201);
        }
    }

    //
}
