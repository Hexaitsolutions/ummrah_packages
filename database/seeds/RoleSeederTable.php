<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Admin;

use Illuminate\Support\Facades\Hash;

class RoleSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new role
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);

        // Create a new admin user
        $admin = new Admin();
        $admin->name = "Admin";
        $admin->phone = "03455555555";
        $admin->password = Hash::make('Allahis1');
        $admin->save();

        // Assign the role to the created admin user
        $admin->assignRole($role->name);
    }
}
