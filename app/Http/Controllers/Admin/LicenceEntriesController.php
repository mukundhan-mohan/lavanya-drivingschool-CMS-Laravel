<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Attendances;
use App\Models\Payments;
use App\Models\Version;
use App\Models\Ledger;
use App\Models\Activity;
use App\Helpers\CustomHelper;
use App\Models\MessageContent;
use DB;
use Auth;

class LicenceEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LicenceEntries::query();

        if($request->get('version_sort') != "") {
            $query->orderBy('licence_entries.version', $request->get('version_sort'));
        }

        if($request->get('id') != "") {
            $query->where('licence_entries.account_no', $request->get('id'));
        }
        if($request->get('name') != "") {
            $query->where('licence_entries.id', $request->get('name'));
        }
        if($request->get('phone_no') != "") {
            $query->where('licence_entries.phone_number', $request->get('phone_no'));
        }
        if($request->get('email') != "") {
            $query->where('licence_entries.email', $request->get('email'));
        }
        if($request->get('version_id') != "") {
            $query->where('licence_entries.version', $request->get('version_id'));
        }
        if($request->get('version_id') != "") {
            $query->where('licence_entries.version', $request->get('version_id'));
        }
        if($request->get('classes') != "") {
            $query->where('licence_entries.no_of_classes', $request->get('classes'));
        }
        if($request->get('amount') != "") {
            $query->where('licence_entries.fees', $request->get('amount'));
        }
        if($request->get('remark') != "") {
            $query->where('licence_entries.remarks', $request->get('remark'));
        }
        $LicenceEnts = $query->select('licence_entries.*','creator.name as creator_name','versions.name as version_name')
        ->where('licence_entries.has_deleted','0')
        ->orderBy('id', 'DESC')
        ->leftJoin('users as creator','creator.id','=','licence_entries.created_by')
        ->leftJoin('versions','versions.id','=','licence_entries.version')->paginate(50);
        $versions = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        $LicenceNames = LicenceEntries::select('licence_entries.*')->groupBy('licence_entries.id')->get();
        return view('admin.licence.index' , compact('LicenceEnts','versions','LicenceNames'));
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
        $data['account_no'] = $account_no = LicenceEntries::max('id');

        return view('admin.licence.create' , compact('enquiries','versions','licenceEnts','account_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($this->convertToDB($request->from));
        // exit();
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
        $remarks = $request->remark;
        $accnt_no = $request->accnt_no;
        $registration_no = $request->registration_no;
        $llr_no = $request->llr_no;
        $from = $this->convertToDB($request->from);
        $to = $this->convertToDB($request->to);
        $notary_remarks = $request->notary_remark;
        $dl_no = $request->dl_no;
        $no_of_class = $request->no_of_class;
        $licence_expirydate = $this->convertToDB($request->exp);
        $issued_at = $this->convertToDB($request->issuedat);
        $balance_amt = $request->balance_amt;
        $advance_if_any = $request->adv_amnt;
        $attender_name = $request->attender_name;
        $enquiry_id = $request->enquiry_id;
        $registration_date = $request->registration_date;

        $account_no = $request->accnt_no;

        

        $entryexistance = LicenceEntries::select('licence_entries.*')->where('licence_entries.account_no','=',$request->accnt_no)->first();

        if(!$entryexistance)
        {
           
            $licenceEnt = new LicenceEntries();
        $licenceEnt->enquiry_id = $enquiry_id;
        $licenceEnt->name = $name;
        $licenceEnt->phone_number = $phone_number;
        $licenceEnt->email = $email;
        $licenceEnt->version = $version_id;
        $licenceEnt->address = $address;
        $licenceEnt->fees = $amount;
        $licenceEnt->no_of_classes = $no_of_class;
        $licenceEnt->remarks = $remarks;
        $licenceEnt->enquiry_date = date('Y-m-d H:i:s');
        $licenceEnt->account_no = $account_no;
        $licenceEnt->llr_no = $llr_no;
        $licenceEnt->from = $from ;
        $licenceEnt->registration_date = $registration_date;
        $licenceEnt->to = $to ;
        $licenceEnt->notary_remarks = $notary_remarks;
        $licenceEnt->dl_no = $dl_no;
        $licenceEnt->licence_expiry_date = $licence_expirydate;
        $licenceEnt->issued_at = $issued_at ;
        $licenceEnt->advance_if_any = $advance_if_any;
        $licenceEnt->balance = $balance_amt;
        $licenceEnt->attender = $attender_name;
        $licenceEnt->created_by = Auth::user()->id;
        $licenceEnt->updated_by = Auth::user()->id;
        $licenceEnt->save();

        if($balance_amt != 0 || $advance_if_any != "" ){
            $receipto_no = Payments::max('id');
            $ll_id = $licenceEnt->id;
            $payments = new Payments();
            $payments->llr_id = $ll_id ? $ll_id : 0;
            $payments->name = $name;
            $payments->accnt_no = $account_no;
            $payments->entry_date = date('Y-m-d H:i:s');
            $payments->old_balance = $advance_if_any;
            $payments->balance = $balance_amt;
            $payments->amount = $advance_if_any;
            $payments->pending_amount = $amount - $advance_if_any;
            $payments->receipt_no = $account_no;
            $payments->updated_by = Auth::user()->id;
            $payments->save();
        }

        
        $Cusinput['is_joined'] = 1;
        CustomerEnquiry::where('id', $enquiry_id)->update($Cusinput);

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Licence";
        $activity->eloquent_id = $account_no;
        $activity->change = "";
        $activity->create_or_update = 'create';
        $activity->save();

        //Whatsapp welcome message
        $wcmsg = MessageContent::select('message_contents.content')->where('message_contents.type','=','welcome_msg')->where('message_contents.is_active', 1)->first();
        if($wcmsg)
        {
            $msg = $wcmsg->content;
            CustomHelper::whatsappSms($msg,$phone_number);
        }
        //Whatsapp welcome message

        return redirect()->route('licencepage')->withSuccess("Record created successfully!");
        }else{
            
        $entryexistance->enquiry_id = $enquiry_id;
        $entryexistance->name = $name;
        $entryexistance->phone_number = $phone_number;
        $entryexistance->email = $email;
        $entryexistance->version = $version_id;
        $entryexistance->address = $address;
        $entryexistance->fees = $amount;
        $entryexistance->no_of_classes = $no_of_class;
        $entryexistance->remarks = $remarks;
        $entryexistance->enquiry_date = date('Y-m-d H:i:s');
        $entryexistance->account_no = $account_no;
        $entryexistance->llr_no = $llr_no;
        $entryexistance->from = $from ;
        $entryexistance->registration_date = $registration_date;
        $entryexistance->to = $to ;
        $entryexistance->notary_remarks = $notary_remarks;
        $entryexistance->dl_no = $dl_no;
        $entryexistance->licence_expiry_date = $licence_expirydate;
        $entryexistance->issued_at = $issued_at ;
        // $entryexistance->advance_if_any = $advance_if_any;
        // $entryexistance->balance = $balance_amt;
        $entryexistance->attender = $attender_name;
        $entryexistance->updated_by = Auth::user()->id;
        $entryexistance->save();

        if($balance_amt != 0 || $advance_if_any != "" ){
            $ll_id = $entryexistance->id;
            $paymentexistance = Payments::select('payments.*')->where('payments.llr_id','=',$ll_id)->first();
            $receipto_no = Payments::max('id');
            if(!$paymentexistance)
            {
                $payments = new Payments();
                $payments->llr_id = $ll_id ? $ll_id : 0;
                $payments->name = $name;
                $payments->accnt_no = $account_no;
                $payments->entry_date = date('Y-m-d H:i:s');
                $payments->old_balance = $advance_if_any;
                $payments->balance = $balance_amt;
                $payments->amount = $advance_if_any;
                $payments->pending_amount = $amount - $advance_if_any;
                $payments->receipt_no = $account_no;
                $payments->updated_by = Auth::user()->id;
                $payments->save();
            }else{
                
            }
            
        }

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Licence";
        $activity->eloquent_id = $account_no;
        $activity->change = "";
        $activity->create_or_update = 'update';
        $activity->save();

        //Whatsapp welcome message
        $wcmsg = MessageContent::select('message_contents.*')->where('message_contents.type','=','welcome_msg')->where('message_contents.is_active', 1)->first();
        if($wcmsg)
        {
            $msg = $wcmsg->content;
            CustomHelper::whatsappSms($msg,$phone_number);
        }
        //Whatsapp welcome message

        return redirect()->route('licencepage')->withSuccess("Record created successfully!");
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LicenceEntries  $licenceEntries
     * @return \Illuminate\Http\Response
     */
    public function show(LicenceEntries $licenceEntries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LicenceEntries  $licenceEntries
     * @return \Illuminate\Http\Response
     */
    public function edit(LicenceEntries $licenceEntries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LicenceEntries  $licenceEntries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicenceEntries $licenceEntries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LicenceEntries  $licenceEntries
     * @return \Illuminate\Http\Response
     */

    public function a2z(Request $request)
    {
        $query = LicenceEntries::query();

        if($request->get('id') != "") {
            $query->where('licence_entries.account_no', $request->get('id'));
        }
        if($request->get('name') != "") {
            $query->where('licence_entries.name', $request->get('name'));
        }
        if($request->get('phone_no') != "") {
            $query->where('licence_entries.phone_number', $request->get('phone_no'));
        }
        if($request->get('email') != "") {
            $query->where('licence_entries.email', $request->get('email'));
        }
        if($request->get('version_id') != "") {
            $query->where('licence_entries.version', $request->get('version_id'));
        }
        if($request->get('version_id') != "") {
            $query->where('licence_entries.version', $request->get('version_id'));
        }
        if($request->get('classes') != "") {
            $query->where('licence_entries.no_of_classes', $request->get('classes'));
        }
        if($request->get('amount') != "") {
            $query->where('licence_entries.fees', $request->get('amount'));
        }
        if($request->get('remark') != "") {
            $query->where('licence_entries.remarks', $request->get('remark'));
        }
        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" licence_entries.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('licence_entries.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('licence_entries.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }
        $data['LicenceEnts'] = $query->select('licence_entries.*','creator.name as creator_name','versions.name as version_name' , 'attendances.no_of_classes as attended_classes',
        DB::raw("(SELECT payments.balance FROM `payments` WHERE payments.created_at = (SELECT Max(created_at) FROM `payments` where payments.llr_id = licence_entries.id)  ) as payment_balance"))
        ->where('licence_entries.has_deleted','0')
        ->orderBy('created_at', 'DESC')
        ->leftJoin('users as creator','creator.id','=','licence_entries.created_by')
        ->leftJoin('attendances','attendances.accnt_no','=','licence_entries.account_no')
        ->leftJoin('payments','payments.llr_id','=','licence_entries.id')
        ->leftJoin('versions','versions.id','=','licence_entries.version')->groupBy('licence_entries.id')->get();
        $data['versions'] = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        
        // print_r($data);
        // exit();
        return view('admin.reports.a2z' , $data);
    }
    public function ledger(Request $request)
    {
        $query = Ledger::query();

        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" ledgers.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('ledgers.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('ledgers.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }
        // $LicenceEnts = $query->select('licence_entries.*','creator.name as creator_name','versions.name as version_name' , 'payments.balance as payment_balance', 'attendances.no_of_classes as attended_classes')
        // ->where('licence_entries.has_deleted','0')
        // ->orderBy('created_at', 'DESC')
        // ->leftJoin('users as creator','creator.id','=','licence_entries.created_by')
        // ->leftJoin('payments','payments.accnt_no','=','licence_entries.account_no')
        // ->leftJoin('attendances','attendances.accnt_no','=','licence_entries.account_no')
        // ->leftJoin('versions','versions.id','=','licence_entries.version')->get();
        // $versions = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        $ledgerInputs = [
            'ledgers.*',
            // DB::raw(" SUM(ledgers.credit) as total_credit "),
        ];

        $LicenceEnts = $query->select($ledgerInputs)->get();
        $totalCredDeb = $query->select(DB::raw(" SUM(ledgers.credit) as total_credit "),DB::raw(" SUM(ledgers.debit) as total_debit "))->first();
        // print_r($totalCredDeb->total_debit);
        // exit(); 
        return view('admin.reports.ledger' , compact('LicenceEnts','totalCredDeb'));
    }
    public function a2zOriginal(Request $request){
        $query = LicenceEntries::query();
        if($request->get('updated_at') != "" && $request->get('updated_at') != 0) {
            $splitRangeUpdate = explode("-", $request->get('updated_at'));
            $splitRangeUpdateStart = date('Y-m-d', strtotime(trim($splitRangeUpdate[0])) ) ;
            $splitRangeUpdateEnd = date('Y-m-d', strtotime(trim($splitRangeUpdate[1])) ) ;
            if($splitRangeUpdateEnd == $splitRangeUpdateStart) {
                $query->whereRaw(" licence_entries.updated_at like '%$splitRangeUpdateStart%' ");
            } else {
                $query->where('licence_entries.updated_at', '>=', $splitRangeUpdateStart." 00:00:00")->where('licence_entries.updated_at', '<=', $splitRangeUpdateEnd." 23:59:59");
            }
        }
        $data['LicenceEnts'] = $query->select('licence_entries.*','creator.name as creator_name','versions.name as version_name' , 'attendances.no_of_classes as attended_classes',
        DB::raw("(SELECT payments.balance FROM `payments` WHERE payments.created_at = (SELECT Max(created_at) FROM `payments` where payments.llr_id = licence_entries.id)  ) as payment_balance"))
        ->where('licence_entries.has_deleted','0')
        ->whereIn('versions.id', array(38,34,28,26,24,22,21))
        ->orderBy('name', 'ASC')
        ->leftJoin('users as creator','creator.id','=','licence_entries.created_by')
        ->leftJoin('attendances','attendances.accnt_no','=','licence_entries.account_no')
        ->leftJoin('payments','payments.llr_id','=','licence_entries.id')
        ->leftJoin('versions','versions.id','=','licence_entries.version')->groupBy('licence_entries.id')->get();
        $data['versions'] = Version::select('versions.*')->where('versions.has_deleted','0')->get();
        return view('admin.reports.a2zOriginale' , $data);
    }
    public function destroy(LicenceEntries $licenceEntries)
    {
        //
    }

    public function convertToDB($date){
        if($date != '' && $date != '0000-00-00 00:00:00') {
            $explodeD = explode(" ", $date);
            $date1 = explode("-", $explodeD[0]);
            return $date1[2]."-".$date1[0]."-".$date1[1]." 00:00:00";
        }
    }

    public function delete(Request $request, $id)
    {
        $LicenceEntries = LicenceEntries::find($id);
        if($LicenceEntries) {
            $LicenceEntries->has_deleted = 1;
            $LicenceEntries->updated_by = auth()->user()->id;
            $LicenceEntries->save();
        }
        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Record deleted successfully!'], 200); 
        }
        return redirect()->route('licencepage')->withSuccess("Record deleted successfully!");
    }
}
