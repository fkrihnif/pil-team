<?php

namespace Modules\FinanceReceipt\App\Models;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;
use Modules\FinanceReceipt\Database\factories\FinanceCashOutHeadModelFactory;

class FinanceCashOutHeadModel extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'finance_cash_out_head';
    protected $guarded = [];

    public function belong_contact()
    {
        return $this->belongsTo(MasterContact::class, 'contact_id', 'id');
    }

    public function belong_account()
    {
        return $this->belongsTo(MasterAccount::class, 'account_id', 'id');
    }

    public function belong_currency()
    {
        return $this->belongsTo(MasterCurrency::class, 'currency_id', 'id');
    }

    public function belong_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function belong_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function job_order()
    {
        return $this->morphTo();
    }

    public function has_details()
    {
        return $this->hasMany(FinanceCashOutDetailModel::class, 'head_id');
    }
}
