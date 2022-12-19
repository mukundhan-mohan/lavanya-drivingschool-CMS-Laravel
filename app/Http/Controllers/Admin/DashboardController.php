<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use App\Models\Attendances;
use App\Models\Payments;
use App\Models\Version;
use App\Models\Vehicles;
use App\Models\Activity;
use Carbon\Carbon;
use DB;
use Auth;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['usersCount'] = User::select(['id'])->active()->count();
        // $data['projectsCount'] = Project::select(['id'])->active()->count();
        // $data['alertsCount'] = Alert::select(['id'])->active()->count();
        // $data['sitesCount'] = Site::select(['id'])->active()->count();
        // $data['topicsCount'] = Tag::select(['id'])->active()->count();
        // $data['forumsCount'] = Forum::select(['id'])->active()->count();
        // $data['publicationsCount'] = Publication::select(['id'])->active()->count();
        // $data['uploadsCount'] = Upload::select(['id'])->whereIn('eloquent', ['forum_comments', 'forums', 'user_files'])->count();
        $data['llr_entries'] = $llr_entries = LicenceEntries::where("has_deleted",0)->count();
        $data['enquiry_entries'] = $enquiry_entries = CustomerEnquiry::where("has_deleted",0)->count();
        $data['balance_amount'] = $balance_amount = LicenceEntries::sum('licence_entries.balance');  
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(7);
        $data['vehicle_oil_service'] = $vehicle_oil_service = Vehicles::select('vehicles.vechicle_no')->where('vehicles.next_oil_service','>=',$startDate)->where('vehicles.next_oil_service','<=',$endDate)->count();   
        return view('admin.dashboard.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
