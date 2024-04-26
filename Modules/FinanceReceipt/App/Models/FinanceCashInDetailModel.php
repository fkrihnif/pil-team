<?php

namespace Modules\FinanceReceipt\App\Models;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Modules\FinanceReceipt\Database\factories\FinanceCashInDetailModelFactory;

class FinanceCashInDetailModel extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    
    protected $table = 'finance_cash_in_detail';
    protected $guarded = [];

    public function belong_head()
    {
        return $this->belongsTo(FinanceCashInHeadModel::class, 'head_id', 'id');
    }

    public function belong_account()
    {
        return $this->belongsTo(MasterAccount::class, 'account_id', 'id');
    }

    public function belong_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function belong_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
