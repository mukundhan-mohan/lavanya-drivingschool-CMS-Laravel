@extends('layouts.global')

@section('title', 'staff attendance')

@section('content')
@php
	$currentTab = "details";
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Staff Attendance</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">staff attendance</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('staff-attendance.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="">
				    <div class="card-body">
                    @foreach($staffs as $staff)
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">{{$staff->name}}</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="{{$staff->id}}" name="{{$staff->name}}" required>
                                <option value="">Select</option>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="half">Half</option>
                              </select>
                            </div> 
                            <button onclick="updateAttendance('{{$staff->id}}')"  id="update23">update</button>
                        </div>
				    @endforeach  
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('staffattendancepage') }}">
                            Cancel
                        </a>
                        <input class="btn  btn-primary" id="create_button" onmouseover="clicked23()" type="" value="Create" >
				       	
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
<script>
function clicked23(){
    $('#update23')[0].click();
}
function updateAttendance(staffid){
    $(".global-popup-loader").show();
    alert(baseurl);
    $status = $('#'+staffid).val();
      $.ajax({
        url: baseurl+"/staff-attendance/"+staffid+"/stroreyed/"+$status+"/save",
        method: 'GET',
        data: "",
        success: function(data){
          $(".global-popup-loader").hide();
          window.history.back();
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });
}
</script>

@endsection