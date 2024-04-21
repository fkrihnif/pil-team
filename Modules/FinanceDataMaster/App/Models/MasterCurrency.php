<?php

namespace Modules\FinanceDataMaster\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FinanceDataMaster\Database\factories\MasterCurrencyFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Marketing\App\Models\QuotationMarketingExport;
use Modules\Marketing\App\Models\QuotationMarketingImport;
use Spatie\Permission\Traits\HasRoles;

class MasterCurrency extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'master_currency';
    protected $guarded = [];

    public function master_accounts()
    {
        return $this->hasMany(MasterAccount::class, 'master_currency_id', 'id');
    }

    public function quotation_marketing_exports()
    {
        return $this->hasMany(QuotationMarketingExport::class, 'currency_id', 'id');
    }

    public function quotation_marketing_imports()
    {
        return $this->hasMany(QuotationMarketingImport::class, 'currency_id', 'id');
    }
}
