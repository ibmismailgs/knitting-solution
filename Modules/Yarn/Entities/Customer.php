<?php

namespace Modules\Yarn\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Yarn\Database\factories\CustomerFactory::new();
    }

    public static function boot(){
        parent::boot();
        
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }

    protected $dates = [ 'deleted_at' ];
}
