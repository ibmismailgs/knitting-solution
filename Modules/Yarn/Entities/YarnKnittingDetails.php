<?php

namespace Modules\Yarn\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\KnittingProgram;

class YarnKnittingDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'yarn_knitting_details';
    // protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Yarn\Database\factories\YarnKnittingDetailsFactory::new();
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

    public function receiveYarn()
    {
        return $this->belongsTo(ReceiveYarn::class, 'receive_id');
    }
    public function knittingProgram()
    {
        return $this->belongsTo(KnittingProgram::class, 'knitting_id');
    }
}
