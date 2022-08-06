<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Party;
use Modules\Account\Entities\Bill;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\ExpenseFactory::new();
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

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    protected $dates = [ 'deleted_at' ];
}
