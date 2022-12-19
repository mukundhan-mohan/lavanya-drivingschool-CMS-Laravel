<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Debit;
use App\Models\Version;
use App\Models\ClassMapping;
use App\Models\Vehicles;
use App\Models\VehicleDebit;
use App\Models\VehicleLog;
use App\Models\Activity;
use DB;
use Auth;

class VehicleLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = VehicleLog::query();

        if($request->get('vehicle_id') != "") {
            $query->where('vehicle_logs.vehicle_id', $request->get('vehicle_id'));
        }

        if($request->get('opening_km') != "") {
            $query->where('vehicle_logs.opening_km', $request->get('opening_km'));
        }

        if($request->get('closing_km') != "") {
            $query->where('vehicle_logs.closing_km', $request->get('closing_km'));
        }

        if($request->get('total_km') != "") {
            $query->where('vehicle_logs.total_km', $request->get('total_km'));
        }

        if($request->get('no_of_classes') != "") {
            $query->where('vehicle_logs.no_of_classes', $request->get('no_of_classes'));
        }

        if($request->get('average') != "") {
            $query->where('vehicle_logs.average', $request->get('average'));
        }

        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" vehicle_logs.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('vehicle_logs.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('vehicle_logs.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }

        $vehicleLogs = $query->select('vehicle_logs.*','vehicles.vechicle_no as vehicle_name')
        ->leftJoin('vehicles','vehicles.id','=','vehicle_logs.vehicle_id')
        ->orderBy('created_at', 'DESC')->paginate(20);
        $vehicles = Vehicles::select('vehicles.*')->where('vehicles.has_deleted','0')->get();
        return view('admin.vehicle-log.index', compact('vehicleLogs','vehicles') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['version'] = $version = Version::find($request->version_id);
        $data['vehicles'] = $vehicles = Vehicles::select('vehicles.*')->where('vehicles.has_deleted','0')->get();
        return view('admin.vehicle-log.create', $data);
    }

    public function totalClasses($date , $vehicleId)
    {
        $query = ClassMapping::query();
        $totalclasses = $query->where('class_mappings.vehicle_id',$vehicleId)->where('class_mappings.entry_date',$date)->sum('class_mappings.no_of_classes');
            return response()->json(
                ['status' => 200,
                'error' => 0,
                'data' => $totalclasses,
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle_id = "";
        $debit_date_formatted = "";
        $opening_km = "";
        $closing_km = "";
        $total_km = "";
        $no_of_classes = "";
        $log_details = "";
        $average = 0;

        $vehicle_id = $request->vehicle_id;
        $debit_date_formatted = $request->debit_date_formatted;
        $opening_km = $request->opening_km;
        $closing_km = $request->closing_km;
        $total_km = $request->total_km;
        $no_of_classes = $request->no_of_classes;
        $log_details = $request->debit_details;
        if($no_of_classes != 0)
        {
            $average = $total_km/$no_of_classes;
        }else{
            $average = 0;
        }

        $VehicleLog = new VehicleLog();
        $VehicleLog->vehicle_id = $vehicle_id;
        $VehicleLog->entry_date = $debit_date_formatted;
        $VehicleLog->opening_km = $opening_km;
        $VehicleLog->closing_km = $closing_km;
        $VehicleLog->total_km = $total_km;
        $VehicleLog->no_of_classes = $no_of_classes;
        $VehicleLog->average = $average;
        $VehicleLog->details = $log_details;
        $VehicleLog->created_by = Auth::user()->id;
        $VehicleLog->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Vehicle Log";
        $activity->eloquent_id = $VehicleLog->id;
        $activity->change = "";
        $activity->create_or_update = 'Create';
        $activity->save();
        return redirect()->route('vehiclelogpage')->withSuccess("Vehicle Log created successfully!");
        

        print_r($total_km/$no_of_classes);
        exit();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleLog  $vehicleLog
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleLog $vehicleLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleLog  $vehicleLog
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleLog $vehicleLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleLog  $vehicleLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleLog $vehicleLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleLog  $vehicleLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleLog $vehicleLog)
    {
        //
    }
}
