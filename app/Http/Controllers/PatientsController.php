<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Doctor;
use App\Models\Complaint;
use App\Models\Patient;

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
        $patient = Patient::Find($patient);
        if (!$patient) {
            return response()->json(['data' => null, 'status' => 'error', 'message' => 'Error Retrieving patients data'], 401);
        }
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


    public function complain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'complaint' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()], 422);
        }

        $user = $request->user();

        $patient = $user->isPatient();

        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Only Patients Can Lay Complaints'], 400);
        }
        $complain = new Complaint(['complaint' => $request->complaint]);

        $patient->complaints()->save($complain);
        return response()->json(['status' => 'success', 'message' => 'Successfully laid complaint', 'data' => $patient->complaints()->without('patient')->latest()->first()], 201);
    }

    public function addDiagnoses()
    {
        // Implement the add Diagnoses method
        return "Hi";
    }


    public function complaints(Request $request, $patient)
    {
        $doctor = Doctor::where('user_id', $request->user()->id)->first();
        $patient = $doctor->patients()->where('patient_id', $patient)->first();
        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Can\'t diagnose without a valid complaint...', 'data' => null], 400);
        }
        return response()->json(['status' => 'success', 'message' => 'Successfully Fetched Complaints', 'data' => $patient->complaints], 201);
    }

    public function medicalRecords(Request $request, $patient = null)
    {
        if (!$patient) {
            $patient = Patient::where('user_id', $request->user()->id)->first();
        } else {
            $patient = Patient::Find($patient);
        }

        // $doctor = Doctor::where('user_id', $request->user()->id)->first();
        // $patient = $doctor->patients()->where('patient_id', $patient)->first();
        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Error Retreiving Patient\'s Record', 'data' => null], 400);
        }
        return response()->json(['status' => 'success', 'message' => 'Successfully Fetched Patient\'s Medical Record', 'data' => $patient->complaints], 200);
    }


    public function fetchDoctor($patient)
    {
        $patient = Patient::Find($patient);
        if (!$patient) {
            return response()->json(['status' => 'error', 'message' => 'Could not find specified patient', 'data' => null], 404);
        }
        // Implement the fetch doctors method
        return response()->json(['status' => 'success', 'message' => 'Successfully fetched all doctors associated to patient', 'data' => $patient->doctors], 200);
    }
    //
}
