<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Debit;
use App\Models\Version;
use App\Models\Vehicles;
use App\Models\VehicleDebit;
use App\Models\Activity;
use DB;
use Auth;

class VehicleDebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = VehicleDebit::query();

        if($request->get('vehicle_id') != "") {
            $query->where('vehicle_debits.vehicle_id', $request->get('vehicle_id'));
        }

        if($request->get('cat_id') != "") {
            $query->where('vehicle_debits.category', $request->get('cat_id'));
        }

        if($request->get('amount') != "") {
            $query->where('vehicle_debits.debit', $request->get('amount'));
        }
        if($request->get('details') != "") {
            $query->where('vehicle_debits.details', $request->get('details'));
        }
        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" vehicle_debits.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('vehicle_debits.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('vehicle_debits.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }

        $VehicleDebits = $query->select('vehicle_debits.*','vehicles.vechicle_no as vehicle_name')
        ->leftJoin('vehicles','vehicles.id','=','vehicle_debits.vehicle_id')
        ->orderBy('created_at', 'DESC')->paginate(20);
        $vehicles = Vehicles::select('vehicles.*')->where('vehicles.has_deleted','0')->get();
        return view('admin.vehicle-debit.index' , compact('VehicleDebits','vehicles'));
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
        return view('admin.vehicle-debit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->debit_details);
        // exit();
        $date = "";
        $amount = "";
        $category = "";
        $debit_details = "";
        $vehicle_id = "";

        $date = $request->debit_date_formatted;
        $amount = $request->amount;
        $category = $request->cat_id;
        $debit_details = $request->debit_details;
        $vehicle_id = $request->vehicle_id;

        $VehicleDebit = new VehicleDebit();
        $VehicleDebit->debit = $amount;
        $VehicleDebit->category = $category;
        $VehicleDebit->date = $date;
        $VehicleDebit->details = $debit_details;
        $VehicleDebit->vehicle_id = $vehicle_id;
        $VehicleDebit->created_by = Auth::user()->id;
        $VehicleDebit->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Vehicle Debit";
        $activity->eloquent_id = $VehicleDebit->id;
        $activity->change = "";
        $activity->create_or_update = 'Create';
        $activity->save();
        return redirect()->route('vehicledebitpage')->withSuccess("Vehicle Debit created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleDebit  $vehicleDebit
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleDebit $vehicleDebit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleDebit  $vehicleDebit
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleDebit $vehicleDebit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleDebit  $vehicleDebit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleDebit $vehicleDebit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleDebit  $vehicleDebit
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleDebit $vehicleDebit)
    {
        //
    }
}
