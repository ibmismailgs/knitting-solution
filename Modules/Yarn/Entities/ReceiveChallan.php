<?php

namespace Modules\Yarn\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Party;

class ReceiveChallan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'yarn_receive_challan';
    
    protected static function newFactory()
    {
        return \Modules\Yarn\Database\factories\ReceiveChallanFactory::new();
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
        public function receive()
    {
        return $this->belongsTo(ReceiveYarn::class, 'receive_id');
    }
    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    protected $dates = [ 'deleted_at' ];
}
