<?php

namespace Modules\Operation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Operation\App\Models\ActivityOperationImport;
use Modules\Operation\App\Models\DocumentActivityOpIm;
use Modules\Operation\App\Models\DocumentArrivalOpIm;
use Modules\Operation\App\Models\DocumentProgressOpIm;
use Modules\Operation\App\Models\OperationImport;
use Modules\Operation\App\Models\ProgressOperationImport;
use Modules\Operation\App\Models\VendorOperationImport;

class OperationImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Fungsi Search
    public function searchIndex($search){
        $index = OperationImport::query();

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
            $operationImports = $this->searchIndex($search); //Memanggil fungsi search
        } else {
            $operationImports = OperationImport::orderBy('id', 'DESC')->paginate(10);
        }
        return view('operation::operation-import.index', compact('operationImports', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operation::operation-import.create');
    }

    public function createProgress(Request $request)
    {
        $operationImport = OperationImport::find($request->id);

        $data = ProgressOperationImport::where('operation_import_id', $operationImport->id)->get() ?? [];
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
         $count = OperationImport::where('job_order_id', '!=', null)->count();
         //cek apakah sudah ada data?
         if ($count > 0) {
             $last_data = OperationImport::where('job_order_id', '!=', null)->orderBy('job_order_id', 'desc')->first()->job_order_id;
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
            
            $data = new OperationImport();
            $data->job_order_id = $this->generateUniqueCode();
            $data->marketing_import_id = null;
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
            $activity = new ActivityOperationImport();
            $activity->operation_import_id = $data->id;
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
            $vendor = new VendorOperationImport();
            $vendor->operation_import_id = $data->id;
            $vendor->vendor = null;
            $vendor->total_charge = null;
            $vendor->transit = $request->transit;
            $vendor->save();

            //insert document activity
            if ($files = $request->file('document_activities')) {
                foreach ($files as $file) {
                    $dataDocument['activity_operation_import_id'] = $activity->id;
                    $dataDocument['document'] = $file->store(
                        'operation-import/activity/documents',
                        'public'
                    );
                    DocumentActivityOpIm::create($dataDocument);
                }
            }

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['operation_import_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-import/documents',
                        'public'
                    );
                    DocumentArrivalOpIm::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.import.index');
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
            
            $data = new ProgressOperationImport();
            $data->operation_import_id = $request->operation_import_id;
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
                    $dataDocuments['progress_operation_import_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-import/progress/documents',
                        'public'
                    );
                    DocumentProgressOpIm::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.import.index');
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
        $operationImport = OperationImport::findOrFail($id);

        $activity = ActivityOperationImport::where('operation_import_id', $id)->first();

        if ($activity) {
            $documentActivity = DocumentActivityOpIm::where('activity_operation_import_id', $activity->id)->get();
        } else {
            $documentActivity = null;
        }

        $documentArrival = DocumentArrivalOpIm::where('operation_import_id', $id)->first();

        if ($documentArrival) {
            $documentArrival = DocumentArrivalOpIm::where('operation_import_id', $id)->get();
        } else {
            $documentArrival = null;
        }

        $vendor = VendorOperationImport::where('operation_import_id', $id)->first();

        if ($vendor) {
            $vendor = VendorOperationImport::where('operation_import_id', $id)->first();
        } else {
            $vendor = null;
        }

        $progress = ProgressOperationImport::where('operation_import_id', $id)->get() ?? [];
        
        return view('operation::operation-import.show', compact('operationImport', 'activity', 'documentActivity', 'documentArrival', 'vendor', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operationImport = OperationImport::findOrFail($id);

        $activity = ActivityOperationImport::where('operation_import_id', $id)->first();

        if ($activity) {
            $documentActivity = DocumentActivityOpIm::where('activity_operation_import_id', $activity->id)->get();
        } else {
            $documentActivity = null;
        }

        $documentArrival = DocumentArrivalOpIm::where('operation_import_id', $id)->first();

        if ($documentArrival) {
            $documentArrival = DocumentArrivalOpIm::where('operation_import_id', $id)->get();
        } else {
            $documentArrival = null;
        }

        $vendor = VendorOperationImport::where('operation_import_id', $id)->first();

        if ($vendor) {
            $vendor = VendorOperationImport::where('operation_import_id', $id)->first();
        } else {
            $vendor = null;
        }
        
        return view('operation::operation-import.edit', compact('operationImport', 'activity', 'documentActivity', 'documentArrival', 'vendor'));
    }

    public function editProgress(Request $request)
    {
        $data = ProgressOperationImport::find($request->id);
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
            
            $data = OperationImport::find($id);
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
                $activity = ActivityOperationImport::find($request->activity_id);
            } else {
                $activity = new ActivityOperationImport();
                $activity->operation_import_id = $id;
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
                $vendor = VendorOperationImport::find($request->vendor_id);
            } else {
                $vendor = new VendorOperationImport();
                $vendor->operation_import_id = $id;
            }

            $vendor->operation_import_id = $data->id;
            $vendor->vendor = null;
            $vendor->total_charge = null;
            $vendor->transit = $request->transit;
            $vendor->save();

            //insert document activity
            if ($files = $request->file('document_activities')) {
                foreach ($files as $file) {
                    $dataDocument['activity_operation_import_id'] = $activity->id;
                    $dataDocument['document'] = $file->store(
                        'operation-import/activity/documents',
                        'public'
                    );
                    DocumentActivityOpIm::create($dataDocument);
                }
            }

            //insert document operation arrival
            if ($files = $request->file('documents')) {
                foreach ($files as $file) {
                    $dataDocuments['operation_import_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-import/documents',
                        'public'
                    );
                    DocumentArrivalOpIm::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.import.index');
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
            
            $data = ProgressOperationImport::find($request->id);
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
                    $dataDocuments['progress_operation_import_id'] = $data->id;
                    $dataDocuments['document'] = $file->store(
                        'operation-import/progress/documents',
                        'public'
                    );
                    DocumentProgressOpIm::create($dataDocuments);
                }
            }

            DB::commit();
            toast('Data Added Successfully!','success');
            return redirect()->route('operation.import.index');
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
        $operationImport = OperationImport::find($id);
        //make  job order id null
        $data = OperationImport::find($id);
        $data->job_order_id = null;
        $data->save();

        $operationImport->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }

    public function deleteProgress($id)
    {
        $progress = ProgressOperationImport::find($id);

        $progress->delete();

        toast('Data Deleted Successfully!','success');
        return redirect()->back();
    }
}
