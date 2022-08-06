<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;
    //
    protected $fillable = ['name', 'guard_name'];
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\RoleFactory::new();
    }
}
