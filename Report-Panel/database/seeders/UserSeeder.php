<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);

        // $permission = Permission::create(['name' => 'edit articles']);

        $admin = User::create([
            'name' => 'admin',
            'phone' => '8801323174104',
            'email' => 'admin@b2m-tech.com',
            'password' => Hash::make('admin@b2m-tech.com'),
        ]);

        $admin->assignRole($adminRole);


    }
}
