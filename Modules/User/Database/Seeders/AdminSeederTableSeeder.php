<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;

class AdminSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call("Modules\User\Database\Seeders\SeedPermissionTableSeeder");

        $user = User::create([
            'name' => 'M H Riad', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->name]);
        // Adding permissions to a user
        $user->givePermissionTo($permissions);
    }
}
