<?php

namespace Modules\FinanceReceipt\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;

class FinanceCashInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('financereceipt::cash_in.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = MasterContact::all();
        $currencies = MasterCurrency::all();
        $accounts = MasterAccount::all();

        return view('financereceipt::cash_in.create', compact('contacts', 'currencies', 'accounts'));
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
