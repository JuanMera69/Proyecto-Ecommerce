<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'cliente']);

        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'editar categorias']);

        $adminRole = Role::findByName('admin');
        $clienteRole = Role::findByName('cliente');

        $adminUser = User::find(1);
        $adminUser->assignRole($adminRole);

        $adminRole->givePermissionTo('crear categorias');
        $adminRole->givePermissionTo('editar categorias');
    }
}