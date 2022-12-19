<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendances;
use App\Models\Staffs;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use App\Models\Version;
use App\Models\Vehicles;
use App\Models\Activity;
use Illuminate\Http\Request;
use DB;
use Auth;

class StaffAttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Staffs::query();
        $staffs = $query->select('staffs.*','users.name as updator_name','creator.name as creator_name')
        ->where('staffs.has_deleted','0')
        ->orderBy('created_at', 'ASC')
        ->leftJoin('users','users.id','=','staffs.updated_by')
        ->leftJoin('users as creator','creator.id','=','staffs.created_by')->paginate(20);

        $staffquerys = StaffAttendances::query();
        $staffquery = $staffquerys->select('staff_attendances.*','staffs.name as staff_name')
        ->leftJoin('staffs','staffs.id','=','staff_attendances.staff_id')
        ->orderBy('staff_attendances.created_at', 'DESC')->get();

        $staffdatequery = StaffAttendances::query();
        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $staffdatequery->whereRaw(" staff_attendances.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $staffdatequery->where('staff_attendances.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('staff_attendances.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }
        $attendancedates = $staffdatequery->select('staff_attendances.attendance_date')
        ->groupBy('staff_attendances.attendance_date')->get();

        return view('admin.staff-attendance.index', compact('staffs','staffquery','attendancedates') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['staffs'] = $staffs = Staffs::select('staffs.*')->where('staffs.has_deleted','0')->get();
        return view('admin.staff-attendance.create', compact('staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        
    }

    public function saveattendance($staffId , $status)
    {
        $staffattendance = StaffAttendances::select('staff_attendances.*')->where('staff_attendances.attendance_date','=',date('Y-m-d'))->where('staff_attendances.staff_id','=',$staffId)->first();
        if(!$staffattendance){
            $staff = new StaffAttendances();
        $staff->attendance_date = date('Y-m-d');
        $staff->staff_id = $staffId;
        $staff->attendance_status = $status;
        $staff->created_by = auth()->user()->id;
        $staff->save();
        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Staff Attendance";
        $activity->eloquent_id = $staffId;
        $activity->change = "";
        $activity->create_or_update = 'update';
        $activity->save();
        return redirect()->route('staffattendancepage')->withSuccess("staff attendance added successfully!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffAttendances  $staffAttendances
     * @return \Illuminate\Http\Response
     */
    public function show(StaffAttendances $staffAttendances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffAttendances  $staffAttendances
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffAttendances $staffAttendances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffAttendances  $staffAttendances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffAttendances $staffAttendances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffAttendances  $staffAttendances
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffAttendances $staffAttendances)
    {
        //
    }
}
