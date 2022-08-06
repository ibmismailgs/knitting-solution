<?php

namespace Modules\Fabric\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Customer;
use Modules\Yarn\Entities\Party;

class FabricReceive extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'fabric_receive';
    
    protected static function newFactory()
    {
        return \Modules\Fabric\Database\factories\FabricReceiveFactory::new();
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    protected $dates = [ 'deleted_at' ];
}
