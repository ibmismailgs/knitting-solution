<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Permission;

class SeedPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission, 'guard_name' => 'api']);
         }

        // $this->call("OthersTableSeeder");
    }
}