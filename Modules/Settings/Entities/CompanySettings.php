<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySettings extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'company_logo','company_name','invoice_logo','company_email','company_phone','company_website','address','copyright_text'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\CompanySettingsFactory::new();
    }
    protected $dates = [ 'deleted_at' ];
}
