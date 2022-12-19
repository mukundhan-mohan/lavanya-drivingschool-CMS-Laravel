@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
	$currentTab = "details";
    $currentUrl = URL::current();

  $versiondatas = "";
  $versionname = "";
  $versionIdr = "";
  $no_of_classes = "";
  $amount = "";
  $enquiryId = "";
  $name = "";
  $phone_no = "";
  $email = "";
  $enquiryId = "";
  $address = "";
  $remark = "";

  $length = 3;
  $string = $account_no+1;
  $accnt_no = str_pad($string,$length,"0", STR_PAD_LEFT);
  $registration_date = "";
  $llr_no = "";
  $from = "";
  $to = "";
  $notary_remarks = "";
  $dl_no = "";
  $no_of_class = "";
  $licence_expirydate = "";
  $issued_at = "";
  $balance_amt = "";
  $advance_if_any = "";
  $attender_name = "";
  $registration_date = date('Y-m-d H:i:s');

  if($enquiries) {
    $versionname = $enquiries->name;
    $amount = $enquiries->fees;
    $name = $enquiries->name;
    $phone_no = $enquiries->phone_number;
    $email = $enquiries->email;
    $address = $enquiries->address;
    $remark = $enquiries->remarks;
    $enquiryId = $enquiries->id ?  $enquiries->id : "";
    $no_of_classes = $enquiries->no_of_classes;
    $versionIdr = $enquiries->version;
    $versiondatas = $versionIdr."_".$amount."_".$no_of_classes;
    
  }

  if($licenceEnts){
    $accnt_no = "$licenceEnts->account_no";
    $registration_no = "";
    $llr_no = $licenceEnts->llr_no;
    $from = $licenceEnts->from ?  \App\Helpers\CustomHelper::convertDate($licenceEnts->from) : "";
    $to = $licenceEnts->to ? \App\Helpers\CustomHelper::convertDate($licenceEnts->to) : "";
    $notary_remarks = $licenceEnts->notary_remarks;
    $dl_no = $licenceEnts->dl_no;
    $licence_expirydate = $licenceEnts->licence_expiry_date;
    $issued_at = $licenceEnts->issued_at;
    $balance_amt = $licenceEnts->balance;
    $advance_if_any = $licenceEnts->advance_if_any;
    $attender_name = $licenceEnts->attender; 
    
    if(!str_contains($currentUrl, 'enq_id')){
        $versionname = $licenceEnts->name;
        $amount = $licenceEnts->fees;
        $name = $licenceEnts->name;
        $phone_no = $licenceEnts->phone_number;
        $email = $licenceEnts->email;
        $address = $licenceEnts->address;
        $remark = $licenceEnts->remarks;
        $no_of_classes = $licenceEnts->no_of_classes;
        $versionIdr = $licenceEnts->version;
        $versiondatas = $versionIdr."_".$amount."_".$no_of_classes;
    }
  }

@endphp

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Add {{ __('message.navmenus.licence') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('versionpage') }}">{{ __('message.navmenus.enquiry') }}</a></div>
              <div class="breadcrumb-item">Add {{ __('message.navmenus.enquiry') }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('licence.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="">
                    <input type="hidden" name="enquiry_id" id="enquiry_id" value="{{$enquiryId}}">
				    <div class="card-body">
                        <div class="form-group">
                            <h3  style="margin-left: 50%;"> Customer Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Account No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="accnt_no" id="accnt_no" value="{{($accnt_no ? $accnt_no : 0)}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Registration Date</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="registration_date" id="registration_date" value="{{$registration_date}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Name</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Name" type="name" name="name" id="name" value="{{$name}}" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Phone Number</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="00 00 0000" type="tel" maxlength="10" name="phone_no" id="phone_no" value="{{$phone_no}}" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">E-Mail</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="E-Mail(optional)" type="email"  name="email" id="email" value="{{$email}}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">LLR No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="LLR No" type="text"  name="llr_no" id="llr_no" value="{{$llr_no}}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Address</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" placeholder="Address" type="address" name="address" id="address" value="{{$address}}" >{{$address}}</textarea>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">From - To</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerlav"  
                                placeholder="{{ __('message.labels.created_at') }}" id="created_range_quickfilter" name="from" value="{{ $from ? $from.' - '.$to : ''}}" autocomplete="off"  onchange="submitForm('user_filter')">
                                <input type="hidden" name="from" id="from" value="">
                                <input type="hidden" name="to" id="to" value="">
                            </div> 
                        </div>
                        
                        
                        <!-- <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">From</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinput"  
                                placeholder="{{ __('message.labels.created_at') }}" id="created_range_quickfilter" name="from" value="{{ $from }}" autocomplete="off"  onchange="submitForm('user_filter')">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">To</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinput"  
                              placeholder="{{ __('message.labels.updated_at') }}" id="updated_range_quickfilter" name="to" value="{{ $to }}" autocomplete="off"  onchange="submitForm('user_filter')">
                            </div> 
                        </div> -->
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Notary Remark</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" placeholder="Notary Remark" type="remark" name="notary_remark" id="notary_remark" value="{{$notary_remarks}}" >{{$notary_remarks}}</textarea>
                            </div>
                        </div>
                        <h3  style="margin-left: 50%;"> Licence Details</h3>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Version</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="version_id" name="version_id" onchange="test(this.value)" required>
                                <option value="">Select</option>
                                @foreach($versions as $key => $version)
                                  <option value="{{  $version->id }}_{{$version->amount}}_{{$version->no_of_classes}}" {{ $version->id."_".$amount."_".$no_of_classes == $versiondatas  ? 'selected' : ''  }}>{{ $version->name }}</option>
                                  <!-- <label type="" id="amt_val" name="amt_value" value="{{$version->amount}}"> -->
                                  $version->id
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">DL No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="DL No" type="text"  name="dl_no" id="dl_no" value="{{$dl_no}}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">No of Classes</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="No of Classes" type="no_of_class" name="no_of_class" id="no_of_class" value="{{$no_of_classes}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Licence Expiry Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerled"  
                                placeholder="{{ __('message.labels.created_at') }}" id="created_range_quickfilter" name="licence_expirydate" value="{{ $licence_expirydate }}" autocomplete="off"  onchange="submitForm('user_filter')">
                                <input type="hidden" name="exp" id="exp" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Fees</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Amount" type="text" name="amount" id="amount" value="{{$amount}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Issued At</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerissuedAt"  
                                placeholder="{{ __('message.labels.created_at') }}" id="created_range_quickfilter" name="issued_at" value="{{ $issued_at }}" autocomplete="off"  onchange="submitForm('user_filter')">
                                <input type="hidden" name="issuedat" id="issuedat" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Advance If Any</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Advance Amount" type="text"  name="adv_amnt" id="adv_amnt" value="{{$advance_if_any}}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Balance</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Balance" type="text"  name="balance_amt" id="balance_amt" onmouseover="Balance()" value="{{$balance_amt}}" readonly >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Remark</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" placeholder="Remark" type="remark" name="remark" id="remark" value="{{$remark}}" >{{$remark}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Attender</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Attender" type="text" name="attender_name" id="attender_name" value="{{$attender_name}}" >
                            </div> 
                        </div>
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('enquirypage') }}">
                            Cancel
                        </a>
                        <input class="btn  btn-primary" id="create_button" type="submit" value="Create" >
				       	
				    </div>
                    </form>
				</div>
			</div>
		  </div>
		 </div>
	</section>
</div>

@endsection

@section('js') 
<script  type="text/javascript">
    $(document).ready(function() {
    $('.select2').select2();
});
    function test(value)
    {
        var valArray = value.split("_");
        var id = valArray[0];
        var amount = valArray[1];
        var classes = valArray[2];
        $('#amount').val(amount);
        $('#no_of_class').val(classes);
    }
    function convertDate($date)
    {
        return date("Y-m-d", strtotime($date));
    }

    function Balance()
    {
        $totl_amt = $('#amount').val();
        $avance_amount = $('#adv_amnt').val();
        if($avance_amount)
        {
            $balace_calc = $totl_amt - $avance_amount;
            if($balace_calc > 0){
                $('#balance_amt').val($balace_calc);
            }else{
                $('#balance_amt').val(0);
            }
        }
    }
</script>

@endsection