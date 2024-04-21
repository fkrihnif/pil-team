<?php

namespace Modules\FinanceDataMaster\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\FinanceDataMaster\App\Models\MasterCurrency;
use Illuminate\Support\Facades\Validator;

class CurrencyDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function searchFilterIndex($search){
        $index = MasterCurrency::query();

        if($search) {
            $index
            ->where('initial','like',"%".$search."%")
            ->orWhere('currency_name','like',"%".$search."%");
        }

        return $index->paginate(10);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $currencies = $this->searchFilterIndex($search);
        } else {
            $currencies = MasterCurrency::orderBy('id', 'DESC')->paginate(10);
        }
        
        return view('financedatamaster::currency.index', compact('currencies'));
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
                'initial'     => 'required|unique:master_currency',
                'currency_name'   => 'required'
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
                'initial'     => 'required|unique:master_currency,initial,'.$request->id,
                'currency_name'   => 'required'
               ],
               [
                 'initial.unique'=> 'The Initial '.$request->initial.' has already been taken', // custom message 
                ]
            );
    
            if ($validator->fails()) {
                toast('failed to update data!','error');
                return redirect()->back()
                            ->withErrors($validator);
            }
        }

        MasterCurrency::updateOrCreate([
            'id' => $request->id
        ],
        [
            'initial' => $request->initial, 
            'currency_name' => $request->currency_name,
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
        $data = MasterCurrency::find($id);
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
        $data = MasterCurrency::find($id);
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
        $currency = MasterCurrency::find($id);
        $currency->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }
}
