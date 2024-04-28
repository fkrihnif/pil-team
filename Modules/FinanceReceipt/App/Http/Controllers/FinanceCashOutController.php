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
use Modules\FinanceReceipt\App\Models\FinanceCashOutDetailModel;
use Modules\FinanceReceipt\App\Models\FinanceCashOutHeadModel;

class FinanceCashOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //has_details_sum_total
        $data = FinanceCashOutHeadModel::withSum('has_details', 'total')->paginate(10);
        foreach ($data as $key => $value) {
            $value->encryptId = encrypt($value->id);
            $value->initial = $value->belong_currency->initial;
            $value->name = $value->belong_contact->customer_name;
        }
        return view('financereceipt::cash_out.index', compact('data'));
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
        $format = FinanceCashOutHeadModel::pluck("transaction_no");
        // Ekstraksi nomor dari setiap entri dan simpan bersama dengan entri
        $entries = [];
        foreach ($format as $transaction_no) {
            $parts = explode('/', $transaction_no);
            $number = intval($parts[2]);
            $entries[] = ['entry' => $transaction_no, 'number' => $number];
        }
        // Urutkan entri berdasarkan nomor terbesar
        usort($entries, function($a, $b) {
            return $b['number'] - $a['number'];
        });

        // Ambil entri dengan nomor terbesar dari setiap kombinasi tahun dan kode awal
        $result = [];
        $grouped = [];
        foreach ($entries as $entry) {
            $parts = explode('/', $entry['entry']);
            $key = $parts[0] . '/' . $parts[1];
            if (!isset($grouped[$key])) {
                $grouped[$key] = true;
                $result[] = $entry['entry'];
            }
        }

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

        return view('financereceipt::cash_out.create', compact('result', 'contacts', 'currencies', 'accounts', 'job_orders', 'accountTypes'));
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

            if (empty($request->is_job_order)) {
                $request->merge([
                    'is_job_order' => null,
                    'job_order_id' => null,
                ]);
            }

            $data->contact_id = $request->contact_id;
            $data->account_id = $request->account_id;
            $data->currency_id = $request->currency_id;
            $data->date = $request->date;
            $data->transaction_no = $request->transaction_no;
            $data->description = $request->description;
            $data->is_job_order = $request->is_job_order;
            $data->job_order_id = $request->job_order_id;
            $data->job_order_type = $request->type_job_order;
            $data->status = 1;
            $data->save();

            //store detail to database
            if ($request->account_detail) {
                for($i = 0; $i < count($request->account_detail); $i++){
                    $detail = FinanceCashOutDetailModel::updateOrCreate(["head_id"=>$data->id, "seq"=>$request->seq_detail[$i]],[
                        'head_id' => $data->id,
                        'description' => $request->description_detail[$i],
                        'account_id' => $request->account_detail[$i],
                        'total' => $request->total_detail[$i],
                        'seq' => $request->seq_detail[$i],
                        'remark' => $request->remark_detail[$i],
                    ]);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('finance.receipt.cash-out.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Data Added Failed!','error');
            return redirect()->route('finance.receipt.cash-out.create')->withErrors($e->getMessage())
            ->withInput();
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
        try {
            $decrypt = decrypt($id);
            $dataCashOut = FinanceCashOutHeadModel::with('has_details')->findOrFail($decrypt);

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

            return view('financereceipt::cash_out.create', compact('dataCashOut','contacts', 'currencies', 'accounts', 'job_orders', 'accountTypes'));
        } catch (\Exception $e) {
            toast('Data Not Found!','error');
            return redirect()->back();
        }
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
