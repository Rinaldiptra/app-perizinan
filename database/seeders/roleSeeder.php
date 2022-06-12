<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\User;
use Spatie\Permission\PermissionRegistrar;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       // Reset cached roles and permissions
       app()[PermissionRegistrar::class]->forgetCachedPermissions();

       // create permissions
       Permission::create(['name' => 'edit perizinan']);
       Permission::create(['name' => 'delete perizinan']);
       Permission::create(['name' => 'update perizinan']);
       Permission::create(['name' => 'create perizinan']);
       Permission::create(['name' => 'approval']);

       // create roles and assign existing permissions
       $role1 = Role::create(['name' => 'staf']);
       $role1->givePermissionTo('edit perizinan');
       $role1->givePermissionTo('delete perizinan');
       $role1->givePermissionTo('update perizinan');
       $role1->givePermissionTo('create perizinan');

       $role2 = Role::create(['name' => 'manager']);
       $role2->givePermissionTo('edit perizinan');
       $role2->givePermissionTo('delete perizinan');
       $role2->givePermissionTo('update perizinan');
       $role2->givePermissionTo('create perizinan');
       $role2->givePermissionTo('approval');

       // create demo users
       $user = \App\Models\User::factory()->create([
           'name' => 'staf 01',
           'email' => 'staf01@gmail.com',
           'password'=>bcrypt('123456789'),
       ]);
       $user->assignRole($role1);

       $user = \App\Models\User::factory()->create([
        'name' => 'staf 02',
        'email' => 'staf02`@gmail.com',
        'password'=>bcrypt('123456789'),
       ]);
       $user->assignRole($role1);

       $user = \App\Models\User::factory()->create([
           'name' => 'Manager',
           'email' => 'manager@gmail.com',
           'password'=>bcrypt('123456789'),
       ]);
       $user->assignRole($role2);

    }
}
