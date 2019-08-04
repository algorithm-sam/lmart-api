<?php

$router->get('/', function () {
    return  "welcome to lmart api home route";
});


// Authentication Requests Route. [register,login,logout] -- Completed -- Tested OK
$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('/register', ['uses' => 'AuthController@register']); // Done Tested Ok
    $router->post('/login', ['uses' => 'AuthController@login']); // Done Tested Ok

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/token/destroy', ['uses' => 'AuthController@logout']); //Done Tested Ok
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


    $router->get('/doctors/{doctor}/patients', ['uses' => 'DoctorsController@allPatients']); /// Done Tested Ok 


    // View Patients --done (tested);
    $router->get('/patients', ['uses' => 'PatientsController@all']); // Done Tested Ok


    // View Relatives --done (tested);
    $router->get('/patients/{patient}/relatives', ['uses' => 'PatientsController@getRelatives']);  // Done Tested Ok

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

    $router->post('/patients/{patient}/relatives', ['uses' => 'RelativesController@store']); // Tested OK

    // View Relatives
    $router->get('/patients/{patient}/relatives', ['uses' => 'RelativesController@all']);


    // Todo Routes

    // view patient medical record
    $router->get('/patients/{patient}/record', ['uses' => 'PatientsController@medicalRecords']); // fetch complaint, diagnosis and treatments
    // add patient medical record
    // $router->post('/patients/{patient}/diagnoses', ['uses' => 'PatientsController@addDiagnoses']);
    // add treatment/diagnoses


    $router->post('diagnosis/{diagnosis}/treatment', ['uses' => 'DoctorsController@addTreatment']); // Done Tested OK;

    $router->get('/patients/{patient}/complaints', ['uses' => 'PatientsController@complaints']); // Done Tested OK;


    $router->post('/complaints/{complaint}/diagnose', ['uses' => 'DoctorsController@diagnose']); // Done Tested Half OK;
});



// Patient's Relative Route


$router->group(['prefix' => 'relative', 'middleware' => 'roles:relative'], function () use ($router) {
    // Patient's Relative Functions

    // Relative Functions


    // Todo Routes
    $router->get('/patients/{patient}/records', ['uses' => 'PatientsController@medicalRecords']);
    // 2. View Patient Doctor

    $router->get('/{patient}/doctor', ['uses' => 'PatientsController@fetchDoctor']); // Done not tested;
});





// Patient's Route..
$router->group(['prefix' => 'patient', 'middleware' => 'roles:patient'], function () use ($router) {

    // Patient Functions

    // View Profile
    // Fetch Medical Record
    // Lay Complaint --Deliberating
    // Chat with Doctor --Deliberating
    // Video Chat with doctor --Not yet implemented

    // $router->get('/', ['uses' => 'PatientsController@index']);

    // Lay Complaint -- Done Tested OK
    $router->post('/complaint', ['uses' => 'PatientsController@complain']); // Done tested Ok;

    $router->get('/records', ['uses' => 'PatientsController@medicalRecords']); // Done Tested Ok;
});



// Done with User Base Route -- Tested OK
// Base User Route.. [update profile, change password] --Completed
$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', ['uses' => 'UsersController@show']);
    $router->patch('/update', ['uses' => 'UsersController@update']);
});
