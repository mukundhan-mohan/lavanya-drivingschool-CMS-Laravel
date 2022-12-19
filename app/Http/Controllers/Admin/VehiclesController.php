<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use App\Models\Activity;
use DB;
use Auth;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Vehicles::query();
        $vehicles = $query->select('vehicles.*','users.name as updator_name','creator.name as creator_name')
        ->where('vehicles.has_deleted','0')
        ->orderBy('created_at', 'DESC')
        ->leftJoin('users','users.id','=','vehicles.updated_by')
        ->leftJoin('users as creator','creator.id','=','vehicles.created_by')->paginate(20);
        return view('admin.vehicles.index' , compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['vehicles'] = $vehicles = Vehicles::find($request->vehicle);
        $data['version'] = $version = Vehicles::find($request->version_id);
        return view('admin.vehicles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->next_water_date_formatted);
        // exit();

        $vehicle_no = "";
        $insurance_date = "";
        $fc_date = "";
        $next_oil_date = "";
        $next_wheel_date = "";
        $next_water_date = "";
        $next_battery_date = "";
        $details = "";

        $vehicle_no = $request->vehicle_no;
        $insurance_date = $request->insurance_date_formatted;
        $fc_date = $request->fc_date_formatted;
        $next_oil_date = $request->next_oil_date_formatted;
        $next_wheel_date = $request->next_wheel_date_formatted;
        $next_water_date = $request->next_water_date_formatted;
        $next_battery_date = $request->next_battery_date_formatted;
        $details = $request->details;

        $entryexistance = Vehicles::select('vehicles.*')->where('vehicles.id','=',$request->vehicleId)->first();


        if(!$entryexistance)
        {
            $vehicles = new Vehicles();
            $vehicles->vechicle_no = $vehicle_no;
            $vehicles->insurance_date = $this->dateformatting($insurance_date);
            $vehicles->fc_date = $this->dateformatting($fc_date);
            $vehicles->next_oil_service = $this->dateformatting($next_oil_date);
            $vehicles->next_wheel_balance = $this->dateformatting($next_wheel_date);
            $vehicles->next_water_service = $this->dateformatting($next_water_date);
            $vehicles->next_battery_service = $this->dateformatting($next_battery_date);
            $vehicles->details = $details;
            $vehicles->created_by = auth()->user()->id;
            $vehicles->updated_by = auth()->user()->id;
            $vehicles->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "Vehicles";
            $activity->eloquent_id = $vehicle_no;
            $activity->change = "";
            $activity->create_or_update = 'create';
            $activity->save();
        }else{
            $entryexistance->vechicle_no = $vehicle_no;
            $entryexistance->insurance_date = $this->dateformatting($insurance_date);
            $entryexistance->fc_date = $this->dateformatting($fc_date);
            $entryexistance->next_oil_service = $this->dateformatting($next_oil_date);
            $entryexistance->next_wheel_balance = $this->dateformatting($next_wheel_date);
            $entryexistance->next_water_service = $this->dateformatting($next_water_date);
            $entryexistance->next_battery_service = $this->dateformatting($next_battery_date);
            $entryexistance->details = $details;
            $entryexistance->updated_by = auth()->user()->id;
            $entryexistance->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "Vehicles";
            $activity->eloquent_id = $vehicle_no;
            $activity->change = "";
            $activity->create_or_update = 'update';
            $activity->save();
        }
        
        return redirect()->route('vehiclespage')->withSuccess("Vehicle created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicles $vehicles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicles $vehicles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicles $vehicles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicles $vehicles)
    {
        //
    }
    public function dateformatting($date)
    {
        $datechange = str_replace("-", "/",$date );
        $dbdate = date('Y-m-d H:i:s', strtotime($datechange));
        return $dbdate;
    }
}
