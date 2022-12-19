<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Staffs;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use App\Models\Version;
use App\Models\Vehicles;
use App\Models\ClassMapping;
use App\Models\Activity;
use App\Models\Payments;
use Illuminate\Http\Request;
use DB;
use Auth;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LicenceEntries::query();

        if($request->get('accnt_no') != "") {
            $query->where('licence_entries.account_no', $request->get('accnt_no'));
        }
        if($request->get('name') != "") {
            $query->where('licence_entries.id', $request->get('name'));
        }
        if($request->get('attended') != "" && $request->get('attended') != 0) {
            $query->where('attendances.no_of_classes', $request->get('attended'));
        }
        if($request->get('vehicle_id') != "") {
            $query->where('attendances.vehicle_id', $request->get('vehicle_id'));
        }
        if($request->get('balance') != "" ) {
            $query->where('payments.balance', $request->get('balance'));
        }

        $inputs = [
            "licence_entries.*",
            "attendances.registration_date",
            "attendances.no_of_classes as attendedclasses",
            "attendances.vehicle_id",
            "attendances.status",
            "vehicles.vechicle_no as vehiclename",
            // "payments.balance as student_balance" 
        ];
        $query->leftJoin('attendances','licence_entries.id', '=','attendances.user_id' );
        $query->leftJoin('vehicles','vehicles.id', '=', 'attendances.vehicle_id');
        $query->leftJoin('users as creator','creator.id','=','licence_entries.created_by');
        // $query->leftJoin('payments','payments.llr_id','=','licence_entries.id');
        $LicenceEnts = $query->select($inputs)
        ->where('licence_entries.has_deleted','0')
        ->orderBy('created_at', 'DESC')
        ->paginate(20);
        $vehicles = Vehicles::select('vehicles.*')->where('vehicles.has_deleted','0')->get();
        $attendanceNames = LicenceEntries::select('licence_entries.id','licence_entries.name')->groupBy('licence_entries.id')->get();
        // print_r($LicenceEnts);
        // exit();
        return view('admin.attendance.index' , compact('LicenceEnts','vehicles','attendanceNames', 'attendanceNames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['enquiries'] = $enquiries = CustomerEnquiry::find($request->enq_id);
        $data['versions'] = $versions = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        $data['licenceEnts'] = $licenceEnts = LicenceEntries::find($request->cus_id);
        $data['vehicles'] = $vehicles = Vehicles::select('vehicles.*')->where('vehicles.has_deleted','0')->get();
        $data['staffs'] = $staffs = Staffs::select('staffs.*')->where('staffs.has_deleted','0')->get();
        $data['attendance'] = $attendance = Attendances::select('attendances.*')->where('attendances.user_id','=',$request->cus_id)->first();
        $data['payments'] = $payments = Payments::select('payments.*')->where('payments.llr_id','=',$request->cus_id)->latest()->first();
        return view('admin.attendance.create' , compact('enquiries','versions','licenceEnts','vehicles','staffs', 'attendance','payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->attended_class);
        // exit();
        $accnt_no = "";
        $registration_date = "";
        $name = "";
        $attended_class = "";
        $vehice_id = "";
        $staff_id = "";
        $status = "";

        $accnt_no = $request->accnt_no;
        $registration_date = $request->registration_date;
        $name = $request->name;
        $attended_class = $request->attended_class;
        $vehice_id = $request->vehice_id;
        $staff_id = $request->staff_id;
        $status = $request->status;

        $attendance = Attendances::select('attendances.*')->where('attendances.user_id','=',$request->cus_id)->first();
        if($attendance){
            $attendance->no_of_classes = $attendance->no_of_classes + $attended_class;
            $attendance->updated_by = auth()->user()->id;
            $attendance->save();

            $classMapping = new ClassMapping();
            $classMapping->vehicle_id = $vehice_id;
            $classMapping->entry_date = date('m-d-Y');
            $classMapping->staff_id = $staff_id;
            $classMapping->no_of_classes = $attended_class;
            $classMapping->student_id = $accnt_no;
            $classMapping->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "attendance";
            $activity->eloquent_id = $accnt_no;
            $activity->change = "";
            $activity->create_or_update = 'update';
            $activity->save();
            return redirect()->route('attendancepage')->withSuccess("Attendance added successfully!");
        }else{
            $attendance = new Attendances();
            $attendance->registration_date = $registration_date;
            $attendance->accnt_no = $accnt_no;
            $attendance->user_id = $request->cus_id;
            $attendance->role = "student";
            $attendance->no_of_classes = $attended_class;
            $attendance->vehicle_id = $vehice_id;
            $attendance->status = $status;
            $attendance->staff_id = $staff_id;
            $attendance->created_by = auth()->user()->id;
            $attendance->updated_by = auth()->user()->id;
            $attendance->save();

            $classMapping = new ClassMapping();
            $classMapping->vehicle_id = $vehice_id;
            $classMapping->entry_date = date('m-d-Y');
            $classMapping->staff_id = $staff_id;
            $classMapping->no_of_classes = $attended_class;
            $classMapping->student_id = $accnt_no;
            $classMapping->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "attendance";
            $activity->eloquent_id = $accnt_no;
            $activity->change = "";
            $activity->create_or_update = 'create';
            $activity->save();
            return redirect()->route('attendancepage')->withSuccess("Attendance added successfully!");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function show(Attendances $attendances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendances $attendances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendances $attendances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendances $attendances)
    {
        //
    }
}
