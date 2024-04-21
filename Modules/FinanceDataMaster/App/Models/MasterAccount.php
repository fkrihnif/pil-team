<?php

namespace Modules\FinanceDataMaster\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FinanceDataMaster\Database\factories\MasterAccountFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class MasterAccount extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'master_account';
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(MasterCurrency::class, 'master_currency_id', 'id');
    }

    public function account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }
}
