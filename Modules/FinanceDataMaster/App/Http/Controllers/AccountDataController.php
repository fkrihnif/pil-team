<?php

namespace Modules\FinanceDataMaster\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\FinanceDataMaster\App\Models\MasterAccount;
use Illuminate\Support\Facades\Validator;
use Modules\FinanceDataMaster\App\Models\AccountType;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;

class AccountDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchFilterIndex($search){
        $index = MasterAccount::query();

        if($search) {
            $index
            ->where('code','like',"%".$search."%")
            ->orWhere('account_name','like',"%".$search."%");
        }

        return $index->paginate(10);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $accounts = $this->searchFilterIndex($search);
        } else {
            $accounts = MasterAccount::orderBy('id', 'DESC')->paginate(10);
        }

        $accountTypes = AccountType::all();
        $currencies = MasterCurrency::all();
        
        return view('financedatamaster::account.index', compact('accounts', 'accountTypes', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('financedatamaster::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->id) {
            //validate store
            $validator = Validator::make($request->all(), [
                'code'     => 'required|unique:master_account',
                'account_name'   => 'required'
            ]);
    
            if ($validator->fails()) {
                toast('failed to add data!','error');
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
        } else {
            //validate edit
            $validator = Validator::make($request->all(),[
                'code'     => 'required|unique:master_account,code,'.$request->id,
                'account_name'   => 'required'
               ],
               [
                 'code.unique'=> 'The code '.$request->code.' has already been taken', // custom message 
                ]
            );
    
            if ($validator->fails()) {
                toast('failed to update data!','error');
                return redirect()->back()
                            ->withErrors($validator);
            }
        }

        MasterAccount::updateOrCreate([
            'id' => $request->id
        ],
        [
            'account_type_id' => $request->account_type_id, 
            'code' => $request->code, 
            'account_name' => $request->account_name,
            'master_currency_id' => $request->master_currency_id,
            'can_delete' => 1
        ]); 

        toast('Data Saved Successfully!','success');
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = MasterAccount::find($id);
        return response()->json([
            'success' => true,
            'data'    => $data
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MasterAccount::find($id);
        return response()->json([
            'success' => true,
            'data'    => $data
        ]); 
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
        $account = MasterAccount::find($id);
        $account->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }
}
