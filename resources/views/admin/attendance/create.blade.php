@extends('layouts.global')

@section('title', 'Attendance')

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

  $accnt_no = "0001";
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
    $from = \App\Helpers\CustomHelper::convertDate($licenceEnts->from);
    $to = \App\Helpers\CustomHelper::convertDate($licenceEnts->to);
    $notary_remarks = $licenceEnts->notary_remarks;
    $dl_no = $licenceEnts->dl_no;
    $licence_expirydate = $licenceEnts->licence_expiry_date;
    $issued_at = $licenceEnts->issued_at;
    $balance_amt = $licenceEnts->balance;
    $advance_if_any = $licenceEnts->advance_if_any;
    $attender_name = $licenceEnts->attender;
    $cus_id =  $licenceEnts->id;
    
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
            <h1>Student Attendance</h1>
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
                <form method="POST" action="{{ route('attendance.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="">
                    <input type="hidden" name="enquiry_id" id="enquiry_id" value="{{$enquiryId}}">
                    <input type="hidden" name="cus_id" id="cus_id" value="{{$cus_id}}">
				    <div class="card-body">
                        <div class="form-group" style="display: block;margin-left: 10px;margin-bottom: 30px">
                            <label>CLASSES ATTENDED - {{ $attendance ? $attendance->no_of_classes : 0 }} / {{$licenceEnts ? $licenceEnts->no_of_classes : 0}}</label></br>
                            <label> Balance Amount - {{ !empty($payments->balance)  ? $payments->balance : 0}}</label>
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Account No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="accnt_no" id="accnt_no" value="{{$accnt_no}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Attendance Date</label>
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
                            <label for="role" class="control-label col-lg-2 col-sm-4">No of Classes</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Enter No of classes" type="text"  name="attended_class" id="attended_class" value="" >
                            </div> 
                        </div>
                        
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Vehicle</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="vehice_id" name="vehice_id" onchange="test(this.value)" required>
                                <option value="">Select</option>
                                @foreach($vehicles as $key => $vehicle)
                                  <option value="{{  $vehicle->id }}"{{ $vehicle->id == (!empty($attendance->vehicleid) ? $attendance->vehicleid : "") ? 'selected' : ''  }} >{{ $vehicle->vechicle_no }}</option>
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">instructor</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="staff_id" name="staff_id" onchange="test(this.value)" required>
                                <option value="">Select</option>
                                @foreach($staffs as $key => $staff)
                                  <option value="{{  $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Status</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="status" name="status" onchange="test(this.value)" required>
                                <option value="">Select</option>
                                <option value="ongoing"{{ (!empty($attendance->status) ? $attendance->status : "") == "ongoing" ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed"{{ (!empty($attendance->status) ? $attendance->status : "") == "completed" ? 'selected' : ''}}>Completed</option>
                              </select>
                            </div> 
                        </div>
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('attendancepage') }}">
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
</script>

@endsection