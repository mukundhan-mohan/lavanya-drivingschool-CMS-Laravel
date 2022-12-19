<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Version;
use App\Models\CustomerEnquiry;
use App\Models\Activity;
use DB;
use Auth;

class CustomerEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CustomerEnquiry::query();

        if($request->get('name') != "") {
            $query->where('customer_enquiries.name', $request->get('name'));
        }
        if($request->get('phone_no') != "") {
            $query->where('customer_enquiries.phone_number', $request->get('phone_no'));
        }
        if($request->get('version_id') != "") {
            $query->where('customer_enquiries.version', $request->get('version_id'));
        }
        if($request->get('classes') != "") {
            $query->where('customer_enquiries.no_of_classes', $request->get('classes'));
        }
        if($request->get('amount') != "") {
            $query->where('customer_enquiries.fees', $request->get('amount'));
        }
        if($request->get('remark') != "") {
            $query->where('customer_enquiries.remarks', $request->get('remark'));
        }
        if($request->get('created_at') != "" && $request->get('created_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('created_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" customer_enquiries.enquiry_date like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('created_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('created_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }

        // DELETE FILTER

        if($request->get('delete_range_records') != "" && $request->get('delete_range_records') != 0)
        {
            $deleteQuery = DB::table('customer_enquiries');
            $splitRangeUpdate = explode("-", $request->get('delete_range_records'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;

            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                CustomerEnquiry::whereRaw("customer_enquiries.enquiry_date like '%$splitRangeUpdateStart%' ")->update(['has_deleted' => 1]);
            } else {
                CustomerEnquiry::where('customer_enquiries.created_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('customer_enquiries.created_at', '<=', $splitRangeUpdateEnd." 23:59:59")->update(['has_deleted' => 1]);
            }
            return redirect()->route('enquirypage')->withSuccess("Record Deleted successfully!");
        }

        // DELETE FILTER

        $CustomerEnqs = $query->select('customer_enquiries.*','creator.name as creator_name','versions.name as version_name')
        ->where('customer_enquiries.has_deleted',0)
        ->orderBy('customer_enquiries.id', 'DESC')
        ->leftJoin('versions','versions.id','=','customer_enquiries.version')
        ->leftJoin('users as creator','creator.id','=','customer_enquiries.created_by')->paginate(20);
        $versions = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        return view('admin.enquiry.index', compact('CustomerEnqs','versions') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = Version::query();
        $versions = $query->select('versions.*')->where('versions.has_deleted','0')->get();

        return view('admin.enquiry.create',compact('versions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $version = $request->version_id;
        $versionDatas =explode("_",$version);
        $version_id = $versionDatas[0];
        $version_amt = $versionDatas[1];
        $version_classes = $versionDatas[2];
        $amount = $request->amount;
        $classes = $request->no_of_class;
        $name = $request->name;
        $phone_number = $request->phone_no;
        $email = $request->email;
        $address = $request->address;
        $remark = $request->remark;


        $customerEnq = new CustomerEnquiry();
        $customerEnq->name = $name;
        $customerEnq->phone_number = $phone_number;
        $customerEnq->email = $email;
        $customerEnq->version = $version_id;

        $customerEnq->address = $address;
        $customerEnq->fees = $amount;
        $customerEnq->no_of_classes = $version_classes;
        $customerEnq->enquiry_date = date('Y-m-d H:i:s');
        $customerEnq->remarks = $remark;
        $customerEnq->created_by = auth()->user()->id;
        $customerEnq->updated_by = auth()->user()->id;
        $customerEnq->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "enquiry";
        $activity->eloquent_id = $customerEnq->id;
        $activity->change = "";
        $activity->create_or_update = 'create';
        $activity->save();
        return redirect()->route('enquirypage')->withSuccess("Record created successfully!");

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerEnquiry  $customerEnquiry
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerEnquiry $customerEnquiry)
    {
        return view('admin.enquiry.show', compact('customerEnquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerEnquiry  $customerEnquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerEnquiry $customerEnquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerEnquiry  $customerEnquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerEnquiry $customerEnquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerEnquiry  $customerEnquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerEnquiry $customerEnquiry)
    {
        //
    }

    public function delete(Request $request, $id)
    {
        $version = CustomerEnquiry::find($id);
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

    public function exportToCsv(Request $request) {
        ini_set('max_execution_time', 0);
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=enquiry-".date('Y-m-d-H-i-s').".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        //$listings = Listing::where('has_deleted', 0)->get();

        $query = CustomerEnquiry::query();

        if($request->get('name') != "") {
            $query->where('customer_enquiries.name', $request->get('name'));
        }
        if($request->get('phone_no') != "") {
            $query->where('customer_enquiries.phone_number', $request->get('phone_no'));
        }
        if($request->get('version_id') != "") {
            $query->where('customer_enquiries.version', $request->get('version_id'));
        }
        if($request->get('classes') != "") {
            $query->where('customer_enquiries.no_of_classes', $request->get('classes'));
        }
        if($request->get('amount') != "") {
            $query->where('customer_enquiries.fees', $request->get('amount'));
        }
        if($request->get('remark') != "") {
            $query->where('customer_enquiries.remarks', $request->get('remark'));
        }
        if($request->get('created_at') != "" && $request->get('created_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('created_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" customer_enquiries.enquiry_date like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('created_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('created_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }

        $customerEnquires = $query->select('customer_enquiries.*','creator.name as creator_name','versions.name as version_name')
        ->where('customer_enquiries.has_deleted',0)
        ->orderBy('created_at', 'DESC')
        ->leftJoin('versions','versions.id','=','customer_enquiries.version')
        ->leftJoin('users as creator','creator.id','=','customer_enquiries.created_by')->get();

        $columns = [
            'Id',
            'Name',
            'Phone No',
            'Version',
            'class',
            'Amount',
            'Remark',
            'Enquiry Date',
            'Status', 
        ];

        $callback = function() use ($customerEnquires, $columns)
        {


            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($customerEnquires as $customerEnquiry) {
                if($customerEnquiry->id!=''){
                    fputcsv($file,
                        [
                            $customerEnquiry->id,
                            $customerEnquiry->name,
                            $customerEnquiry->phone_number,
                            $customerEnquiry->version_name,
                            $customerEnquiry->no_of_classes,
                            $customerEnquiry->fees,
                            $customerEnquiry->remarks,
                            $customerEnquiry->resort_name,
                            $customerEnquiry->EnquiryFormated
                        ]
                    );

                }
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
