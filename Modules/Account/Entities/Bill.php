<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Customer;
use Modules\Yarn\Entities\Party;
use Modules\Fabric\Entities\FabricDelivery;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table='bills';
    
    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\BillFactory::new();
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
        return $this->belongsTo(Party::class,'party_id');
    }

    public function delivery()
    {
        return $this->belongsTo(FabricDelivery::class,'delivery_id');
    }

    protected $dates = [ 'deleted_at' ];
}
