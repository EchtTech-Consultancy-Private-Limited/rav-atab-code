<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'title' => 'Mr.',
            'firstname' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile_no' => '7982645011',
            'password' => Hash::make('12345678'),
            'role' => 1,
            'status' => 1
        ]);
        //DB::table('users')->update(['password'=>bcrypt('12345678')],$user->id);


    }
}
