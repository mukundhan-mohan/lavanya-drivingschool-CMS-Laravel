@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
	$currentTab = "details";

  $title = "";
  $no_of_classes = "";
  $amount = "";
  $versionId = "";
  if($version) {
    $title = $version->name;
    $no_of_classes = $version->no_of_classes;
    $amount = $version->amount;
    $versionId = $version->id ;
  }

@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Staff</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('staffspage') }}">Staffs</a></div>
              <div class="breadcrumb-item">Create Staff</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('staffs.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="staffId" id="staffId" value="{{$staffs ? $staffs->id : ""}}">
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Name</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Name" type="text" name="name" id="name" value="{{ $staffs ? $staffs->name : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Staff Code</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Staff Code" type="text" name="staff_code" id="staff_code" value="{{ $staffs ? $staffs->staff_code : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Father/Spouse Name</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Father/Spouse Name" type="text" name="father_or_spouse" id="father_or_spouse" value="{{ $staffs ? $staffs->father_or_spouse : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Mobile No</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Mobile No" type="text" name="mobile_no" id="mobile_no" value="{{ $staffs ? $staffs->mobile_no : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Email</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Email" type="text" name="email" id="email" value="{{ $staffs ? $staffs->email : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Address</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Address" type="text" name="address" id="address" value="{{ $staffs ? $staffs->address : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Previous Experience</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Previous Experience" type="text" name="previous_exp" id="previous_exp" value="{{ $staffs ? $staffs->previous_experience : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Total Experience</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Total Experience" type="text" name="total_exp" id="total_exp" value="{{ $staffs ? $staffs->total_experience : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Education Qualification</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Education Qualification" type="text" name="education_qual" id="education_qual" value="{{ $staffs ? $staffs->education_qualification : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Co-curricular activities</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Co-curricular activities" type="text" name="co_activities" id="co_activities" value="{{ $staffs ? $staffs->curricular_activities : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Interested Area</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Interested Area" type="text" name="Interested_area" id="Interested_area" value="{{ $staffs ? $staffs->interested_area : "" }}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Joining Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Joining Date" id="joining_date" name="created_at"  autocomplete="off"  onchange="test('joining_date')" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="joining_date_formatted" name="joining_date_formatted" value="{{ $staffs ? $staffs->joining_date : "" }}">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Designation</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Designation" type="text" name="designation" id="designation" value="{{ $staffs ? $staffs->designation : "" }}" >
                            </div> 
                        </div>
                        
                        <!-- <div class="form-group">
                            <label for="avatar" class="control-label col-lg-2 col-sm-4">Avatar</label>
                            <div class="col-lg-10 col-sm-8">
                            <input class="form-control singleimagepreview" placeholder="Choose Image" data-preview="avatar_preview" accept="image/*" id="avatar" type="file" name="avatar">
                            </div> 
                        </div>
				       <div class="form-group image-previwgroup">
                          <label for="meta_description" class="control-label col-lg-2 col-sm-4"></label>
                          <div class="col-lg-10 col-sm-8">
                            <img src="" width="100" height="100" id="avatar_preview" class="display-none">
                          </div>
                        </div>
                        <a href="javascript:;" id="first" onClick="test('joining_date');" class="btn btn-primary" style="display: none"></a> -->
                        
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('staffspage') }}">
                            Cancel
                        </a>
                        <input class="btn  btn-primary" id="create_button" onmouseover="clicked1()" type="submit" value="Create" >
				       	
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
function test(value){
    var contactdate = $('#'+value).val();
    var datetransform = contactdate.replaceAll("/", "-");
    var insurancedate = $('#'+value+'_formatted').val(datetransform);
    
    // alert(datetransform);
}

function clicked1(){
    $('#first')[0].click();
    $('#second')[0].click();
    $('#third')[0].click();
    $('#fourth')[0].click();
    $('#fifth')[0].click();
    $('#sixth')[0].click();

}

</script>
@endsection