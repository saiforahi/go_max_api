<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'first_name' => 'Mr Super',
            'last_name'=>'Admin',
            'email' => 'admin@mail.com',
            'phone'=> '01XXXXXXXXX',
            'password' => Hash::make('12345678'),
            //'last_login_ip' => 'Male',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'first_name' => 'Mr User',
            'last_name'=>'',
            'email' => 'user@mail.com',
            'phone'=> '01YYYYYYYYY',
            'password' => Hash::make('12345678'),
            //'gender' => 'Male',
        ]);
        $user->assignRole($role2);
        
    }
}