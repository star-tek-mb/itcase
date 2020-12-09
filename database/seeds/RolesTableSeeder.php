<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_customer = new Role();
        $role_customer->name = 'customer';
        $role_customer->description = 'Заказчик';
        $role_customer->save();

        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'Администратор';
        $role_admin->save();
    }
}
