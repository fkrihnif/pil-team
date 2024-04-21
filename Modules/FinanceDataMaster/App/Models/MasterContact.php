<?php

namespace Modules\FinanceDataMaster\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FinanceDataMaster\Database\factories\MasterContactFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Marketing\App\Models\MarketingExport;
use Modules\Marketing\App\Models\MarketingImport;
use Spatie\Permission\Traits\HasRoles;

class MasterContact extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'master_contact';
    protected $guarded = [];

    public function marketing_exports()
    {
        return $this->hasMany(MarketingExport::class, 'contact_id', 'id');
    }

    public function marketing_imports()
    {
        return $this->hasMany(MarketingImport::class, 'contact_id', 'id');
    }

    public function termPaymentContacts()
    {
        return $this->hasMany(TermPaymentContact::class, 'contact_id', 'id');
    }
}
