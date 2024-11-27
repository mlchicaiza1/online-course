<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'view courses']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage comments']);
        Permission::create(['name' => 'manage videos']);
        Permission::create(['name' => 'manage categories']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage courses',
            'manage users',
            'view courses',
            'manage comments',
            'manage videos',
            'manage categories'
        ]);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(['view courses']);

       $userCreate = User::create(
            [
                'name'=>'admin',
                'email'=>'admin@admin.com',
                'password' =>bcrypt('12345678'),
            ]
        );
        $userCreate->assignRole('admin');

    }
}
