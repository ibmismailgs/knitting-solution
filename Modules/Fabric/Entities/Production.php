<?php

namespace Modules\Fabric\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Customer;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\KnittingProgram;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\Yarn\Entities\Employee;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;

class Production extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Fabric\Database\factories\ProductionFactory::new();
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
        return $this->belongsTo(Customer::class, 'operator_name');
    }

    public function party()
    {
        return $this->belongsTo(Party::class,'party_id');
    }

    public function knittingprogram()
    {
        return $this->belongsTo(KnittingProgram::class,'knitting_id');
    }
    public function knittingprogramDetails()
    {
        return $this->belongsTo(YarnKnittingDetails::class,'yarn_knitting_details_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function productionDetails()
    {
        return $this->hasMany(KnittingProductionDetail::class,'production_id');
    }
    protected $dates = [ 'deleted_at' ];
}
