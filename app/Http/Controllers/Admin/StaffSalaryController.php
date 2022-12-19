<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staffs;
use App\Models\Version;
use App\Models\Debit;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use App\Helpers\FileHelper;
use App\Models\Activity;
use DB;
use Auth;

class StaffSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = StaffSalary::query();

        if($request->get('amount') != "") {
            $query->where('staff_salaries.debit', $request->get('amount'));
        }
        if($request->get('details') != "") {
            $query->where('staff_salaries.details', $request->get('details'));
        }
        if($request->get('cat_id') != "") {
            $query->where('staff_salaries.category', $request->get('cat_id'));
        }
        if($request->get('name') != "") {
            $query->where('staff_salaries.name', $request->get('name'));
        }
        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" staff_salaries.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('staff_salaries.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('staff_salaries.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }

        $staffSalaries = $query->select('staff_salaries.*' , 'staffs.name as staff_name')
        ->leftJoin('staffs','staffs.id', '=','staff_salaries.staff_id' )
        ->orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.staff-salary.index', compact('staffSalaries') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['staff'] = $staff = Staffs::find($request->version_id);
        $data['staffs'] = $staffs = Staffs::select('staffs.*')->where('staffs.has_deleted','0')->get();
        return view('admin.staff-salary.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = "";
        $amount = "";
        $staff_id = "";
        $category = "";
        $debit_details = "";

        $date = $request->debit_date_formatted;
        $amount = $request->amount;
        $staff_id = $request->staff_id;
        $category = $request->cat_id;
        $debit_details = $request->debit_details;

        $staffSalary = new StaffSalary();
        $staffSalary->debit = $amount;
        $staffSalary->category = $category;
        $staffSalary->staff_id = $staff_id;
        $staffSalary->date = $date;
        $staffSalary->details = $debit_details;
        $staffSalary->created_by = Auth::user()->id;
        $staffSalary->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "staff salary";
        $activity->eloquent_id = $staffSalary->id;
        $activity->change = "";
        $activity->create_or_update = 'Create';
        $activity->save();
        return redirect()->route('staffsalarypage')->withSuccess("staff salary created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffSalary  $staffSalary
     * @return \Illuminate\Http\Response
     */
    public function show(StaffSalary $staffSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffSalary  $staffSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffSalary $staffSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffSalary  $staffSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffSalary $staffSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffSalary  $staffSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffSalary $staffSalary)
    {
        //
    }
}
