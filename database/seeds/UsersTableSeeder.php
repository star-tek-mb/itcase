<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();

        $admin_user = new User();
        $admin_user->first_name = 'Admin';
        $admin_user->email = 'admin@example.com';
        $admin_user->password = Hash::make('example');
        $admin_user->save();
        $admin_user->roles()->attach($role_admin);
    }
}
