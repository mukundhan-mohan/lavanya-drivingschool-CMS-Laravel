<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staffs;
use App\Models\Version;
use Illuminate\Http\Request;
use App\Helpers\FileHelper;
use App\Models\Activity;
use DB;
use Auth;

class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Staffs::query();
        $staffs = $query->select('staffs.*','users.name as updator_name','creator.name as creator_name')
        ->where('staffs.has_deleted','0')
        ->orderBy('created_at', 'DESC')
        ->leftJoin('users','users.id','=','staffs.updated_by')
        ->leftJoin('users as creator','creator.id','=','staffs.created_by')->paginate(20);
        return view('admin.staffs.index', compact('staffs') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['staffs'] = $staffs = Staffs::find($request->staff_id);
        $data['version'] = $version = Version::find($request->version_id);
        return view('admin.staffs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($name);
        // exit();
        $name = "";
        $staff_code = "";
        $father_or_spouse = "";
        $mobile_no = "";
        $email = "";
        $address = "";
        $previous_exp = "";
        $total_exp = "";
        $education_qual = "";
        $co_activities = "";
        $Interested_area = "";
        $joining_date = "";
        $designation = "";

        $name = $request->name;
        $staff_code = $request->staff_code;
        $father_or_spouse = $request->father_or_spouse;
        $mobile_no = $request->mobile_no;
        $email = $request->email;
        $address = $request->address;
        $previous_exp = $request->previous_exp;
        $total_exp = $request->total_exp;
        $education_qual = $request->education_qual;
        $co_activities = $request->co_activities;
        $Interested_area = $request->Interested_area;
        $joining_date = $request->joining_date_formatted;
        $designation = $request->designation;

        $entryexistance = Staffs::select('staffs.*')->where('staffs.id','=',$request->staffId)->first();

        if(!$entryexistance)
        {
            $staff = new Staffs();
            $staff->name = $name;
            $staff->staff_code = $staff_code;
            $staff->father_or_spouse = $father_or_spouse;
            $staff->mobile_no = $mobile_no;
            $staff->email = $email;
            $staff->address = $address;
            $staff->previous_experience = $previous_exp;
            $staff->total_experience = $total_exp;
            $staff->education_qualification = $education_qual;
            $staff->curricular_activities = $co_activities;
            $staff->interested_area = $Interested_area;
            $staff->joining_date = $this->dateformatting($joining_date);
            $staff->designation = $designation;
            $staff->updated_by = auth()->user()->id;
            $staff->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "Staffs";
            $activity->eloquent_id = $staff_code;
            $activity->change = "";
            $activity->create_or_update = 'create';
            $activity->save();
        }else{
        $entryexistance->name = $name;
        $entryexistance->staff_code = $staff_code;
        $entryexistance->father_or_spouse = $father_or_spouse;
        $entryexistance->mobile_no = $mobile_no;
        $entryexistance->email = $email;
        $entryexistance->address = $address;
        $entryexistance->previous_experience = $previous_exp;
        $entryexistance->total_experience = $total_exp;
        $entryexistance->education_qualification = $education_qual;
        $entryexistance->curricular_activities = $co_activities;
        $entryexistance->interested_area = $Interested_area;
        $entryexistance->joining_date = $this->dateformatting($joining_date);
        $entryexistance->designation = $designation;
        $entryexistance->created_by = auth()->user()->id;
        $entryexistance->updated_by = auth()->user()->id;
        $entryexistance->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Staffs";
        $activity->eloquent_id = $staff_code;
        $activity->change = "";
        $activity->create_or_update = 'update';
        $activity->save();
        }
        

        // if($request->file('avatar')) {
        //     $image = $request->file('avatar');
        //     $avatar_path = 'images/avatar/'.$staff->id."/";
        //     $imageName =  FileHelper::saveImage($image, 'avatar_dimention',  $avatar_path);
        //     $staff->avatar = $imageName;
        //     $staff->save();
        // }

        return redirect()->route('staffspage')->withSuccess("staff added successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function show(Staffs $staffs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function edit(Staffs $staffs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staffs $staffs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staffs $staffs)
    {
        //
    }

    public function delete(Request $request, $id)
    {
        $version = Staffs::find($id);
        if($version) {
            $version->has_deleted = 1;
            $version->updated_by = auth()->user()->id;
            $version->save();
        }
        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Record deleted successfully!'], 200); 
        }
        return redirect()->route('enquiry.index')->withSuccess("Record deleted successfully!");
    }

    public function dateformatting($date)
    {
        $datechange = str_replace("-", "/",$date );
        $dbdate = date('Y-m-d H:i:s', strtotime($datechange));
        return $dbdate;
    }
}
