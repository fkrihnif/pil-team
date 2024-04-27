<?php

namespace Modules\FinanceReceipt\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Modules\Marketing\App\Models\MarketingExport;
use Modules\Marketing\App\Models\MarketingImport;
use Modules\FinanceDataMaster\App\Models\AccountType;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Modules\FinanceDataMaster\App\Models\MasterContact;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;
use Modules\FinanceReceipt\App\Models\FinanceCashOutHeadModel;

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
        $accountTypes = AccountType::all();

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

        return view('financereceipt::cash_out.create', compact('contacts', 'currencies', 'accounts', 'job_orders', 'accountTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            DB::beginTransaction();
            //Insert marketing to Database

            if ($request->old_id) {
                $data = FinanceCashOutHeadModel::find($request->old_id);
                $validator = Validator::make($request->all(), [
                    'contact_id' => ['required'],
                    'account_id' => ['required'],
                    'currency_id' => ['required'],
                    'date' => ['required'],
                    'transaction_no' => ['required', 'unique:finance_cash_out_head,transaction_no,NULL,NULL,deleted_at,NULL'],
                    'job_order_id' => ['required_if:is_job_order,==,1'],
                ]);

                $data->updated_by = auth()->user()->id;
            } else {
                $data = new FinanceCashOutHeadModel();

                $validator = Validator::make($request->all(), [
                    'contact_id' => ['required'],
                    'account_id' => ['required'],
                    'currency_id' => ['required'],
                    'date' => ['required'],
                    'transaction_no' => ['required', 'unique:finance_cash_out_head,transaction_no,'.$request->old_id.',id,deleted_at,NULL'],
                    'job_order_id' => ['required_if:is_job_order,==,1'],
                ]);

                $data->created_by = auth()->user()->id;
            }

            if ($validator->fails()) {
                toast('failed to add data!','error');
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $data->contact_id = $request->contact_id;
            $data->account_id = $request->account_id;
            $data->currency_id = $request->currency_id;
            $data->date = $request->date;
            $data->transaction_no = $request->transaction_no;
            $data->description = $request->description;
            $data->is_job_order = $request->is_job_order;
            $data->job_order_id = $request->job_order_id;
            $data->save();

            //store dimension to database
            // if ($request->panjang) {
            // for($i = 0; $i < count($request->panjang); $i++){
            //     $dimension = DimensionMarketingExport::create([
            //         'marketing_export_id' => $data->id,
            //         'packages' => $request->packages[$i],
            //         'length' => $request->panjang[$i],
            //         'width' => $request->lebar[$i],
            //         'height' => $request->tinggi[$i],
            //         'input_measure' => $request->user_input[$i],
            //         'qty' => $request->quantity[$i],
            //     ]);
            //     }
            // }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('marketing.export.index');
        } catch (\Exception $e) {
            toast('Data Added Failed!','error');
            return redirect()->route('marketing.export.create');
        }
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
