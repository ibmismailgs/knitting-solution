<?php

namespace Modules\Yarn\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\ReceiveYarn;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'yarn_stockss';

    
    protected static function newFactory()
    {
        return \Modules\Yarn\Database\factories\StockFactory::new();
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function receiveYarn()
    {
        return $this->belongsTo(ReceiveYarn::class, 'receive_id');
    }
    protected $dates = ['deleted_at'];
}
