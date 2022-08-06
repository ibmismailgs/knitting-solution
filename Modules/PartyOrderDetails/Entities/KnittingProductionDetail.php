<?php

namespace Modules\PartyOrderDetails\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Customer;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\KnittingProgram;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\Yarn\Entities\Employee;
use Modules\Fabric\Entities\FabricReceive;
use Modules\Fabric\Entities\Production;

class KnittingProductionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\PartyOrderDetails\Database\factories\KnittingProductionDetailFactory::new();
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
    public function knittingprogram()
    {
        return $this->belongsTo(KnittingProgram::class, 'knitting_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function production()
    {
        return $this->belongsTo(Production::class, 'production_id');
    }
    public function knittingprogramDetails()
    {
        return $this->belongsTo(YarnKnittingDetails::class, 'yarn_knitting_details_id');
    }
    protected $dates = ['deleted_at'];
}
