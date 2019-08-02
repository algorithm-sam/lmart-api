<?php

$router->get('/', function () {
    return  "welcome to lmart api home route";
});


// Authentication Requests Route. [register,login,logout] -- Completed -- Tested OK
$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('/register', ['uses' => 'AuthController@register']);
    $router->post('/login', ['uses' => 'AuthController@login']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/token/destroy', ['uses' => 'AuthController@logout']);
    });
});

// Admin User Route ....
$router->group(['prefix' => 'admin', 'middleware' => 'roles:admin'], function () use ($router) {

    $router->get('/doctors', ['uses' => 'DoctorsController@index']); // done Tested OK

    $router->post('/doctors/add', ['uses' => 'DoctorsController@store']); // done Tested OK

    $router->delete('/doctors/{doctor}/delete', ['uses' => 'DoctorsController@destroy']); // done Tested OK

    $router->patch('/doctors/{doctor}/edit', ['uses' => 'DoctorsController@edit']); // done Tested OK

    // View a particular doctor's patients

    // The Segments Below are yet to be implemented

    // --Done (Not yet tested)
    $router->get('/doctors/{doctor}/patients', ['uses' => 'DoctorsController@allPatients']);


    // View Patients --done (Not yet tested);
    $router->get('/patients', ['uses' => 'PatientsController@all']);


    // View Relatives --done (Not yet tested);
    $router->get('/patients/{patient}/relatives', ['uses' => 'PatientController@getRelatives']);


    // view chat history between doctor and client  -- deliberating (Not yet implemented);

});


// Doctor's Route
$router->group(['prefix' => 'doctor', 'middleware' => 'roles:doctor'], function () use ($router) {
    // Doctor Functions

    // 1. Add Patient
    // 2. Add Relative
    // 3. Add Patient's Medical Record --Deliberating
    // 4. View Patient Medical Records -- Deliberating
    // 5. Add Treatments/ Diagnoses -- Deliberating
    // 6. View All Patients

    // Add patient

    $router->post('patients/add', ['uses' => 'PatientsController@store']); // Tested OK;

    $router->get('/patients', ['uses' => 'DoctorsController@allPatients']); // Tested OK;

    // Add Relative

    $router->post('/patients/{patient}/relatives', ['uses' => 'RelativesController@store']);

    // View Relatives
    $router->get('/patients/{patient}/relatives', ['uses' => 'RelativesController@all']);


    // Todo Routes

    // view patient medical record
    $router->get('/patients/{patient}/record', ['uses' => 'PatientsController@medicalRecords']);
    // add patient medical record
    $router->post('/patients/{patient}/diagnoses', ['uses' => 'PatientsController@addDiagnoses']);
    // add treatment/diagnoses
    $router->post('patients/{patient}/treatment', ['uses' => 'PatientsController@addTreatment']);
});



// Patient's Relative Route


$router->group(['prefix' => 'relative', 'middleware' => 'roles:relative'], function () use ($router) {
    // Patient's Relative Functions

    // Relative Functions


    // Todo Routes
    $router->get('/{patient}/records', ['uses' => 'PatientsController@medicalRecords']);
    // 2. View Patient Doctor

    $router->get('/{patient}/doctor', ['uses' => 'PatientsController@fetchDoctor']);
});





// Patient's Route..
$router->group(['prefix' => 'patient', 'middleware' => 'roles:patient'], function () use ($router) {

    // Patient Functions

    // View Profile
    // Fetch Medical Record
    // Lay Complaint --Delibrating
    // Chat with Doctor --Deliberating
    // Video Chat with doctor --Not yet implemented

    // $router->get('/', ['uses' => 'PatientsController@index']);

    // Lay Complaint -- Done Tested OK
    $router->post('/complaint', ['uses' => 'PatientsController@complain']);

    $router->get('/records', ['uses' => 'PatientsController@medicalRecords']);
});



// Done with User Base Route -- Tested OK
// Base User Route.. [update profile, change password] --Completed
$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', ['uses' => 'UsersController@show']);
    $router->patch('/update', ['uses' => 'UsersController@update']);
});
