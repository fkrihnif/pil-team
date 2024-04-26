<?php

namespace Modules\FinanceReceipt\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;
use Modules\Marketing\App\Models\MarketingExport;
use Modules\Marketing\App\Models\MarketingImport;

class FinanceCashOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('financereceipt::cash_out.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = MasterContact::all();
        $currencies = MasterCurrency::all();
        $accounts = MasterAccount::all();

        $export = MarketingExport::where("status", 2)->get();
        $import = MarketingImport::where("status", 2)->get();

        $job_orders = $export->concat($import);

        foreach ($job_orders as $key_j => $value_j) {
            if ($value_j instanceof MarketingExport) {
                $value_j->type = "Export";
            } elseif ($value_j instanceof MarketingImport) {
                // Proses jika $value_j adalah instance dari MarketingImport
                $value_j->type = "Import";
            }
        }

        return view('financereceipt::cash_out.create', compact('contacts', 'currencies', 'accounts', 'job_orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('financereceipt::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('financereceipt::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
