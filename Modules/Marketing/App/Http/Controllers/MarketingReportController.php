<?php

namespace Modules\Marketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Marketing\App\Models\MarketingExport;
use Modules\Marketing\App\Models\MarketingImport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MarketingReportController extends Controller
{
    //Fungsi filter
    public function filterIndex($filterStatus, $filterFrom, $filterTo){
        $export = MarketingExport::with('quotation')->where('status', $filterStatus)->orWhere('origin', $filterFrom)->orWhere('destination', $filterTo)->get();

        $import = MarketingImport::with('quotation')->where('status', $filterStatus)->orWhere('origin', $filterFrom)->orWhere('destination', $filterTo)->get();

        $mergedData = $export->merge($import);

        return $mergedData;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterStatus = $request->get('status');
        $filterFrom = $request->get('from');
        $filterTo = $request->get('to');

        if ($filterStatus || $filterFrom || $filterTo) {
            $mergedData = $this->filterIndex($filterStatus, $filterFrom, $filterTo); //Memanggil filter
        } else {
            $export = MarketingExport::with('quotation')->get();
            $import = MarketingImport::with('quotation')->get();
            $mergedData = $export->concat($import);
        }

        // Konversi hasil query menjadi Collection
        $collection = new Collection($mergedData);

        // Buat instance LengthAwarePaginator secara manual
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $total = $collection->count();

        $paginator = new LengthAwarePaginator($items, $total, $perPage, $currentPage, ['path' => url('marketing/report')]);
            
        $exportFilter = MarketingExport::with('quotation');
        $mergedDataFilter = MarketingImport::with('quotation')->union($exportFilter)->get();
        return view('marketing::marketing-report.index', compact('mergedData', 'mergedDataFilter', 'filterStatus', 'filterFrom', 'filterTo', 'paginator'));
    }

    public function exportPdf (Request $request)
    {
        $filterStatus = $request->get('status');
        $filterFrom = $request->get('from');
        $filterTo = $request->get('to');

        if ($filterStatus || $filterFrom || $filterTo) {
            $export = MarketingExport::with('quotation')->where('status', $filterStatus)->orWhere('origin', $filterFrom)->orWhere('destination', $filterTo)->get();

            $import = MarketingImport::with('quotation')->where('status', $filterStatus)->orWhere('origin', $filterFrom)->orWhere('destination', $filterTo)->get();
    
            $mergedData = $export->merge($import);
        } else {
            $export = MarketingExport::with('quotation')->get();
            $import = MarketingImport::with('quotation')->get();
            $mergedData = $export->merge($import);
        }

        //memanggil view untuk export pdf
        $pdf = app('dompdf.wrapper')->loadView('marketing::marketing-report.marketing-report-pdf',['data'=>$mergedData]);
        return $pdf->stream('marketing-export.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marketing::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('marketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('marketing::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
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
