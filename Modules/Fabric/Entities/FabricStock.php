<?php

namespace Modules\Fabric\Entities;

use Modules\Yarn\Entities\Party;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Fabric\Entities\FabricReceive;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FabricStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'fabric_stocks';

    protected static function newFactory()
    {
        return \Modules\Fabric\Database\factories\FabricStockFactory::new();
    }
    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function receiveFabric()
    {
        return $this->belongsTo(FabricReceive::class, 'receive_id');
    }
}
