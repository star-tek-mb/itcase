<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class ContractorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_customer = new Role();
        $role_customer->name = 'contractor';
        $role_customer->description = 'Исполнитель';
        $role_customer->save();
    }
}
