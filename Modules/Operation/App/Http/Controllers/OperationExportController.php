<?php

namespace Modules\Operation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Operation\App\Models\ActivityOperationExport;
use Modules\Operation\App\Models\DocumentActivityOpEx;
use Modules\Operation\App\Models\DocumentArrivalOpEx;
use Modules\Operation\App\Models\OperationExport;
use Modules\Operation\App\Models\VendorOperationExport;
use Illuminate\Support\Facades\DB;
use Modules\Operation\App\Models\DocumentProgressOpEx;
use Modules\Operation\App\Models\ProgressOperationExport;

class OperationExportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Fungsi Search
    public function searchIndex($search){
        $index = OperationExport::query();

        //Jika input search terisi
        if($search) {
            $index->whereHas('marketing', function ($query) use ($search){
                $query->where('job_order_id', 'like', '%'.$search.'%');
            })
            ->orWhere('departure_date','like',"%".$search."%")
            ->orWhere('arrival_date','like',"%".$search."%")
            ->orWhere('origin','like',"%".$search."%")
            ->orWhere('destination','like',"%".$search."%")
            ->orWhere('recepient_name','like',"%".$search."%");

            if (str_contains("ON - PROGRESS", strtoupper($search), )) {
                $index->orWhere('status', 1);
            } 
            if (str_contains("END - PROGRESS", strtoupper($search), )) {
                $index->orWhere('status', 2);
            }
        }
    
        return $index->paginate(10);
    }
    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $operationExports = $this->searchIndex($search); //Memanggil fungsi search
        } else {
            $operationExports = OperationExport::orderBy('id', 'DESC')->paginate(10);
        }
        return view('operation::operation-export.index', compact('operationExports', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operation::operation-export.create');
    }

    public function createProgress(Request $request)
    {
        $operationExport = OperationExport::find($request->id);

        $data = ProgressOperationExport::where('operation_export_id', $operationExport->id)->get() ?? [];
        return response()->json([
            'success' => true,
            'data'    => $data
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateUniqueCode()
     {
         $count = OperationExport::where('job_order_id', '!=', null)->count();
         //cek apakah sudah ada data?
         if ($count > 0) {
             $last_data = OperationExport::where('job_order_id', '!=', null)->orderBy('job_order_id', 'desc')->first()->job_order_id;
             $removed4char = substr($last_data, -5);
             $generate_code = 'OPIL' . '-' .  str_pad($removed4char + 1, 5, "0", STR_PAD_LEFT);
         } else {
             $generate_code = 'OPIL' . '-' . str_pad(1, 5, "0", STR_PAD_LEFT);
         }
 
         return $generate_code;
     }


    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            //Insert data operation to Database
            
            $data = new OperationExport();
            $data->job_order_id = $this->generateUniqueCode();
            $data->marketing_export_id = null;
            $data->origin = $request->origin;
            $data->pickup_address = $request->pickup_address;
            $data->pickup_address_desc = $request->pickup_address_desc;
            $data->pickup_date = $request->pickup_date;
            $data->transportation = $request->transportation;
            $data->transportation_desc = $request->transportation_desc;
            $data->departure_date = $request->departure_date;
            $data->departure_time = $request->departure_time;
            //arrival
            $data->destination = $request->destination;
            $data->arrival_date = $request->arrival_date;
            $data->arrival_time = $request->arrival_time;
            $data->delivery_address = $request->delivery_address;
            $data->delivery_address_desc = $request->delivery_address_desc;
            $data->recepient_name = $request->recepient_name;
            $data->arrival_desc = $request->arrival_desc;
            $data->remark = $request->remark;
            $data->status = $request->status;
            $data->save();

            //store activity to database
            $activity = new ActivityOperationExport();
            $activity->operation_export_id = $data->id;
            $activity->batam_entry_date = $request->batam_entry_date;
            $activity->batam_exit_date = $request->batam_exit_date;
            $activity->destination_entry_date = $request->destination_entry_date;
            $activity->warehouse_entry_date = $request->warehouse_entry_date;
            $activity->warehouse_exit_date = $request->warehouse_exit_date;
            $activity->client_received_date = $request->client_received_date;
            $activity->sin_entry_date = $request->sin_entry_date;
            $activity->sin_exit_date = $request->sin_exit_date;
            $activity->return_pod_date = $request->return_pod_date;
            $activity->save();

            //store vendor to databse
            $vendor = new VendorOperationExport();
            $vendor->operation_export_id = $data->id;
            $vendor->vendor = null;
            $vendor->total_charge = null;
            $vendor->transit = $request->transit;
            $vendor->save();

            //insert document activity
            if ($files = $request->file('document_activities')) {
                foreach ($files as $file) {
                    $dataDocument['activity_operation_export_id'] = $activity->id;
                    $dataDocument['document'] = $file->store(
                        'operation-export/activity/documents',
                        'public'
                    );
                    DocumentActivityOpEx::create($dataDocument);
                }
            }

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['operation_export_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-export/documents',
                        'public'
                    );
                    DocumentArrivalOpEx::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.export.index');
        } catch (\Exception $e) {
            toast('Data Added Failed!','error');
            return redirect()->back()->withInput();
        }
    }

    public function storeProgress(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            //Insert data operation to Database
            
            $data = new ProgressOperationExport();
            $data->operation_export_id = $request->operation_export_id;
            $data->date_progress = $request->date_progress;
            $data->time_progress = $request->time_progress;
            $data->location = $request->location;
            $data->location_desc = $request->location_desc;
            $data->transportation = $request->transportation;
            $data->transportation_desc = $request->transportation_desc;
            $data->carrier = $request->carrier;
            $data->description = $request->description;
            $data->save();

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['progress_operation_export_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-export/progress/documents',
                        'public'
                    );
                    DocumentProgressOpEx::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.export.index');
        } catch (\Exception $e) {
            toast('Data Added Failed!','error');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $operationExport = OperationExport::findOrFail($id);

        $activity = ActivityOperationExport::where('operation_export_id', $id)->first();

        if ($activity) {
            $documentActivity = DocumentActivityOpEx::where('activity_operation_export_id', $activity->id)->get();
        } else {
            $documentActivity = null;
        }

        $documentArrival = DocumentArrivalOpEx::where('operation_export_id', $id)->first();

        if ($documentArrival) {
            $documentArrival = DocumentArrivalOpEx::where('operation_export_id', $id)->get();
        } else {
            $documentArrival = null;
        }

        $vendor = VendorOperationExport::where('operation_export_id', $id)->first();

        if ($vendor) {
            $vendor = VendorOperationExport::where('operation_export_id', $id)->first();
        } else {
            $vendor = null;
        }

        $progress = ProgressOperationExport::where('operation_export_id', $id)->get() ?? [];
        
        return view('operation::operation-export.show', compact('operationExport', 'activity', 'documentActivity', 'documentArrival', 'vendor', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operationExport = OperationExport::findOrFail($id);

        $activity = ActivityOperationExport::where('operation_export_id', $id)->first();

        if ($activity) {
            $documentActivity = DocumentActivityOpEx::where('activity_operation_export_id', $activity->id)->get();
        } else {
            $documentActivity = null;
        }

        $documentArrival = DocumentArrivalOpEx::where('operation_export_id', $id)->first();

        if ($documentArrival) {
            $documentArrival = DocumentArrivalOpEx::where('operation_export_id', $id)->get();
        } else {
            $documentArrival = null;
        }

        $vendor = VendorOperationExport::where('operation_export_id', $id)->first();

        if ($vendor) {
            $vendor = VendorOperationExport::where('operation_export_id', $id)->first();
        } else {
            $vendor = null;
        }
        
        return view('operation::operation-export.edit', compact('operationExport', 'activity', 'documentActivity', 'documentArrival', 'vendor'));

    }

    public function editProgress(Request $request)
    {
        $data = ProgressOperationExport::find($request->id);
        return response()->json([
            'success' => true,
            'data'    => $data
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            //update data operation to Database
            
            $data = OperationExport::find($id);
            $data->origin = $request->origin;
            $data->pickup_address = $request->pickup_address;
            $data->pickup_address_desc = $request->pickup_address_desc;
            $data->pickup_date = $request->pickup_date;
            $data->transportation = $request->transportation;
            if ($request->transportation == 3) {
                $data->transportation_desc = null;
            } else {
                $data->transportation_desc = $request->transportation_desc;
            }
            
            $data->departure_date = $request->departure_date;
            $data->departure_time = $request->departure_time;
            //arrival
            $data->destination = $request->destination;
            $data->arrival_date = $request->arrival_date;
            $data->arrival_time = $request->arrival_time;
            $data->delivery_address = $request->delivery_address;
            $data->delivery_address_desc = $request->delivery_address_desc;
            $data->recepient_name = $request->recepient_name;
            $data->arrival_desc = $request->arrival_desc;
            $data->remark = $request->remark;
            $data->status = $request->status;
            $data->save();

            //update activity to database

            //cek if activity id exist
            if ($request->activity_id) {
                $activity = ActivityOperationExport::find($request->activity_id);
            } else {
                $activity = new ActivityOperationExport();
                $activity->operation_export_id = $id;
            }

            $activity->batam_entry_date = $request->batam_entry_date;
            $activity->batam_exit_date = $request->batam_exit_date;
            $activity->destination_entry_date = $request->destination_entry_date;
            $activity->warehouse_entry_date = $request->warehouse_entry_date;
            $activity->warehouse_exit_date = $request->warehouse_exit_date;
            $activity->client_received_date = $request->client_received_date;
            $activity->sin_entry_date = $request->sin_entry_date;
            $activity->sin_exit_date = $request->sin_exit_date;
            $activity->return_pod_date = $request->return_pod_date;
            $activity->save();


            //update vendor to databse
            if ($request->vendor_id) {
                $vendor = VendorOperationExport::find($request->vendor_id);
            } else {
                $vendor = new VendorOperationExport();
                $vendor->operation_export_id = $id;
            }

            $vendor->operation_export_id = $data->id;
            $vendor->vendor = null;
            $vendor->total_charge = null;
            $vendor->transit = $request->transit;
            $vendor->save();

            //insert document activity
            if ($files = $request->file('document_activities')) {
                foreach ($files as $file) {
                    $dataDocument['activity_operation_export_id'] = $activity->id;
                    $dataDocument['document'] = $file->store(
                        'operation-export/activity/documents',
                        'public'
                    );
                    DocumentActivityOpEx::create($dataDocument);
                }
            }

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['operation_export_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-export/documents',
                        'public'
                    );
                    DocumentArrivalOpEx::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.export.index');
        } catch (\Exception $e) {
            toast('Data Added Failed!','error');
            return redirect()->back()->withInput();
        }   
    }

    public function updateProgress (Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            //Insert data operation to Database
            
            $data = ProgressOperationExport::find($request->id);
            $data->date_progress = $request->date_progress;
            $data->time_progress = $request->time_progress;
            $data->location = $request->location;
            $data->location_desc = $request->location_desc;
            $data->transportation = $request->transportation_edit;
            $data->transportation_desc = $request->transportation_desc;
            $data->carrier = $request->carrier;
            $data->description = $request->description;
            $data->save();

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['progress_operation_export_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-export/progress/documents',
                        'public'
                    );
                    DocumentProgressOpEx::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.export.index');
        } catch (\Exception $e) {
            toast('Data Added Failed!','error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $operationExport = OperationExport::find($id);
        //make  job order id null
        $data = OperationExport::find($id);
        $data->job_order_id = null;
        $data->save();

        $operationExport->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }

    public function deleteProgress($id)
    {
        $progress = ProgressOperationExport::find($id);

        $progress->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }
}
