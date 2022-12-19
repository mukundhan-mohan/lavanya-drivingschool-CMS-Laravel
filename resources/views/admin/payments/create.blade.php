@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
	$currentTab = "details";
    $currentUrl = URL::current();

  $versiondatas = "";
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
    $from = \App\Helpers\CustomHelper::convertDate($licenceEnts->from);
    $to = \App\Helpers\CustomHelper::convertDate($licenceEnts->to);
    $notary_remarks = $licenceEnts->notary_remarks;
    $dl_no = $licenceEnts->dl_no;
    $licence_expirydate = $licenceEnts->licence_expiry_date;
    $issued_at = $licenceEnts->issued_at;
    $balance_amt = $licenceEnts->balance;
    $advance_if_any = $licenceEnts->advance_if_any;
    $attender_name = $licenceEnts->attender; 
    
    if(!str_contains($currentUrl, 'enq_id')){
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

  if($payments){
        $name = $payments->name;
        $phone_no = $payments->phone_number;
  }

//   echo $payments;
//   exit();

@endphp

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Add Payment</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('versionpage') }}">Payments</a></div>
              <div class="breadcrumb-item">Add Payment</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="">
                    <input type="hidden" name="enquiry_id" id="enquiry_id" value="{{$enquiryId}}">
                    <input type="hidden" name="llr_id" id="llr_id" value="{{$payments->llr_id}}">
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Account No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="accnt_no" id="accnt_no" value="{{($accnt_no ? $accnt_no : 0)}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Payment Date</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="registration_date" id="registration_date" value="{{$registration_date}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Name</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Name" type="name" name="name" id="name" value="{{$name}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Phone Number</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="00 00 0000" type="tel" maxlength="10" name="phone_no" id="phone_no" value="{{$phone_no}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Receipt No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="LLR No" type="text"  name="receipt_no" id="receipt_no" value="{{ $accnt_no ? $accnt_no : 0}}" readonly>
                            </div> 
                        </div>    
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Balance</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Balance" type="text"  name="balance_amt" id="balance_amt" value="{{$payments->balance}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Amount</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Amount" type="number"  name="paying_amt" id="paying_amt" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Current Pending amount</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="0" type="text"  name="curr_amt" id="curr_amt" value="" onmouseover="curramt()" readonly>
                            </div> 
                        </div>
				    </div>
				    <div class="card-footer">
				        <a class="btn  btn-default" href="{{ route('paymentspage') }}">
                            Cancel
                        </a>
                        <input class="btn  btn-primary" id="create_button" type="submit" value="Create Payment" onmouseover="amountCheck()">
				       	
				    </div>
                    </form>
				</div>
			</div>
		  </div>
		 </div>
	</section>
</div>
<style>
@media (min-width: 992px)
    {
        .col-lg-12 {
    flex: 0 0 83.3333333333%;
    max-width: 60% !important;
    }
}
@media (min-width: 992px)
{
    .col-lg-10 {
        flex: 0 0 83.3333333333%;
        max-width: 50.333333%;
    }
}

</style>

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
    function amountCheck()
    {
       var paying_amt = $('#paying_amt').val();
       var balance_amt = $('#balance_amt').val();
    //    if(parseInt(paying_amt) > parseInt(balance_amt))
    //    {
    //     alert("payment amount is larger than balance amount");
    //    }
    }
    function curramt(){
        var paying_amt = $('#paying_amt').val();
        var balance_amt = $('#balance_amt').val();
        var curramt = balance_amt - paying_amt;
        if(parseInt(curramt) > 0){
            $('#curr_amt').val(curramt);
        }else{
            $('#curr_amt').val(0);
        }
        
    }
</script>

@endsection