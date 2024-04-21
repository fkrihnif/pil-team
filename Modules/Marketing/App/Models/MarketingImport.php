<?php

namespace Modules\Marketing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Marketing\Database\factories\MarketingImportFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\Operation\App\Models\OperationImport;
use Spatie\Permission\Traits\HasRoles;

class MarketingImport extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'marketing_import';
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo(MasterContact::class, 'contact_id','id');
    }

    public function dimensions()
    {
        return $this->hasMany(DimensionMarketingImport::class, 'marketing_import_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(DocumentMarketingImport::class, 'marketing_import_id', 'id');
    }

    public function quotation()
    {
        return $this->hasOne(QuotationMarketingImport::class, 'marketing_import_id', 'id');
    }

    public function operations()
    {
        return $this->hasMany(OperationImport::class, 'marketing_import_id', 'id');
    }
    
}
