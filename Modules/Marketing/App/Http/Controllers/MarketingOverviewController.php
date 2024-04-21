<?php

namespace Modules\Marketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Marketing\App\Models\MarketingExport;
use Modules\Marketing\App\Models\MarketingImport;

class MarketingOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countMEx = MarketingExport::count();

        $marketingExport = MarketingExport::orderBy('id', 'DESC')->paginate(5);
        $marketingImport = MarketingImport::orderBy('id', 'DESC')->paginate(5);
        return view('marketing::marketing-overview.index', compact('countMEx', 'marketingExport', 'marketingImport'));
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
