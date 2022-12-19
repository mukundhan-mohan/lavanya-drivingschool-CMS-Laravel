<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceEntries;
use App\Models\Payments;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Version;
use App\Models\Activity;
use DB;
use Auth;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Payments::query();

        if($request->get('accnt_no') != "") {
            $query->where('payments.accnt_no', $request->get('accnt_no'));
        }
        if($request->get('name') != "") {
            $query->where('payments.llr_id', $request->get('name'));
        }
        if($request->get('bill_no') != "") {
            $query->where('payments.accnt_no', $request->get('bill_no'));
        }
        if($request->get('balance') != "") {
            $query->where('payments.balance', $request->get('balance'));
        }
        if($request->get('payment') != "") {
            $query->where('payments.amount', $request->get('payment'));
        }
        if($request->get('pending_amount') != "") {
            $query->where('payments.pending_amount', $request->get('pending_amount'));
        }

        $payments = $query->select('payments.*','creator.name as creator_name')
        ->orderBy('created_at', 'DESC')
        ->leftJoin('users as creator','creator.id','=','payments.updated_by')
        ->leftJoin('licence_entries','licence_entries.id','=','payments.llr_id')->paginate(20);
        $paymentsName = Payments::select('payments.*')->groupBy('payments.name')->get();
        return view('admin.payments.index' , compact('payments' , 'paymentsName'));
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
        $data['payments'] = $payments = Payments::select('payments.*','licence_entries.name','licence_entries.phone_number')->where('payments.id',$request->payment_id)
        ->leftJoin('licence_entries','licence_entries.account_no','=','payments.accnt_no')->first();
        $data['receipt_no'] = $receipt_no = Payments::select('payments.id')->count();
        // print_r($data['payments']);
        // exit();
        return view('admin.payments.create' , compact('enquiries','versions','licenceEnts','account_no','payments','receipt_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->paying_amt);
        // exit();
        $llr_id = "";
        $name = "";
        $accnt_no = "";
        $entry_date = "";
        $balance = "";
        $amount = "";
        $pending_amount = "";
        $old_balance = "";
        $receipt_no = "";
        $updated_by = "";

        $llr_id = $request->llr_id;
        $name = $request->name;
        $accnt_no = $request->accnt_no;
        $entry_date = $request->registration_date;
        $balance =  $request->balance_amt - $request->paying_amt >= 0 ? $request->balance_amt - $request->paying_amt : 0;
        $amount = $request->paying_amt;
        $pending_amount = $request->balance_amt - $request->paying_amt >= 0 ? $request->balance_amt - $request->paying_amt : 0;
        $old_balance = "";
        $receipt_no = $request->receipt_no;
        $updated_by = Auth::user()->id;



        $payments = new Payments();
        $payments->llr_id = $llr_id;
        $payments->name = $name;
        $payments->accnt_no = $accnt_no;
        $payments->entry_date = date('Y-m-d H:i:s');
        $payments->old_balance = "";
        $payments->balance = $balance;
        $payments->amount = $amount;
        $payments->pending_amount = $pending_amount;
        $payments->receipt_no = $receipt_no ;
        $payments->updated_by = Auth::user()->id;
        $payments->save();

        $licenceEntries = LicenceEntries::where('licence_entries.id',$llr_id)->where('licence_entries.phone_number',$request->phone_no)->first();

        $licenceEntries->balance = $balance;
        $licenceEntries->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Payments";
        $activity->eloquent_id = $accnt_no;
        $activity->change = "";
        $activity->create_or_update = 'Update';
        $activity->save();
        return redirect()->route('paymentspage')->withSuccess("payment added successfully!");
    }


    public function sms($paymentId)
    {
        $payments = Payments::select('payments.*','licence_entries.*')->where('payments.id','=',$paymentId)
        ->leftJoin('licence_entries','licence_entries.id','=','payments.llr_id')->first();
        // print_r($payments->phone_number);
        // exit();

        // $files = attach("http://staging.thedynasty.in/images/whatsapp.png");
        
        $body = "Hi... ".ucfirst($payments->name).", we have not received pending amount of Rs.".$payments->pending_amount.". Please pay your pending amount as soon as possible. \nQuestions? Call us at 422 4397807 \nWarm Regards,\n-The Lavanya Driving School 🚗";
        
        $username="mukundhan";

        $password="!Mukundhan1";

        $message= $body->attach("http://staging.thedynasty.in/images/whatsapp.png");

        $mobile_number= $payments->phone_number;

        // $url ="https://login.bulksmsgateway.in/textmobilesmsapi.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&type=".urlencode('3');
        // return response()->json(
        //     ['status' => 200,
        //     'error' => 0,
        //     'data' => $url,
        // ], 200);
        // echo fopen($url);
        // try {
        //     \App\Http\Controllers\Admin\TwilioSMSController::sendSms($body , $payments->phone_number);
        // } catch (TwilioException $e) {
        // }catch (\Twilio\Exceptions\RestException $e) {
        // }

        $url ="https://login.bulksmsgateway.in/textmobilesmsapi.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&type=".urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_scraped_page = curl_exec($ch);

        curl_close($ch);
    }

    public function paymentrouteID($accountId)
    {
        $paymentID =  Payments::select('payments.id','payments.llr_id')->where('payments.accnt_no', $accountId)->latest()->first();
        //return redirect()->route('payments.create', array('cus_id' => $paymentID));
        return response()->json(
            ['status' => 200,
            'error' => 0,
            'data' => $paymentID,
        ], 200);
    }
    public function paymentrouteNameID($name)
    {
        $paymentID =  Payments::select('payments.id','payments.llr_id')->where('payments.llr_id', $name)->latest()->first();
        //return redirect()->route('payments.create', array('cus_id' => $paymentID));
        return response()->json(
            ['status' => 200,
            'error' => 0,
            'data' => $paymentID,
        ], 200);
    }
    public function paymentroutePhoneID($phone_no)
    {
        $paymentID =  Payments::select('payments.id','payments.llr_id')
        ->leftJoin('licence_entries','licence_entries.id','=','payments.llr_id')
        ->where('licence_entries.phone_number', $phone_no)
        ->latest('payments.created_at')->first();
        //return redirect()->route('payments.create', array('cus_id' => $paymentID));
        return response()->json(
            ['status' => 200,
            'error' => 0,
            'data' => $paymentID,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
