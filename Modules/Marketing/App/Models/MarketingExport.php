<?php

namespace Modules\Marketing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Marketing\Database\factories\MarketingExportFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\Operation\App\Models\OperationExport;
use Spatie\Permission\Traits\HasRoles;

class MarketingExport extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'marketing_export';
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo(MasterContact::class, 'contact_id','id');
    }

    public function dimensions()
    {
        return $this->hasMany(DimensionMarketingExport::class, 'marketing_export_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(DocumentMarketingExport::class, 'marketing_export_id', 'id');
    }

    public function quotation()
    {
        return $this->hasOne(QuotationMarketingExport::class, 'marketing_export_id', 'id');
    }

    public function operations()
    {
        return $this->hasMany(OperationExport::class, 'marketing_export_id', 'id');
    }
}
