<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        //
        Role::insert([
            ['name' => 'user', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'patient', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'relative', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'doctor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin', 'created_at' => $now, 'updated_at' => $now]
        ]);
    }
}
