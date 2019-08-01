<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\User;
use App\Models\Doctor;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('roles:admin');
    }

    public function index()
    {
        return "This is the doctors endpoint";
    }

    public function addDoctor(Request $request)
    { }

    public function addPatientRelative()
    { }

    //
}
