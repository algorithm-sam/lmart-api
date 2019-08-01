<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        $adminRole = Role::where('name', 'admin')->first();
        $doctorsRole = Role::where('name', 'doctor')->first();
        $relativeRole = Role::where('name', 'relative')->first();
        $patientRole = Role::where('name', 'patient')->first();
        $userRole = Role::where('name', 'user')->first();


        $user = User::create(['name' => 'user', 'email' => 'user@user.com', 'password' => Hash::make('password'), 'created_at' => $now, 'updated_at' => $now]);
        $user->roles()->attach($userRole);

        $patient = User::create(['name' => 'patient', 'email' => 'patient@patient.com', 'password' => Hash::make('password'), 'created_at' => $now, 'updated_at' => $now]);
        $patient->roles()->attach($patientRole);

        $relative = User::create(['name' => 'relative', 'email' => 'relative@relative.com', 'password' => Hash::make('password'), 'created_at' => $now, 'updated_at' => $now]);
        $relative->roles()->attach($relativeRole);

        $doctor = User::create(['name' => 'doctor', 'email' => 'doctor@doctor.com', 'password' => Hash::make('password'), 'created_at' => $now, 'updated_at' => $now]);
        $doctor->roles()->attach($doctorsRole);

        $admin = User::create(['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('password'), 'created_at' => $now, 'updated_at' => $now]);
        $admin->roles()->attach($adminRole);
    }
}
