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
        $role_contractor = new Role();
        $role_contractor->name = 'contractor';
        $role_contractor->description = 'Исполнитель';
        $role_contractor->save();
    }
}
