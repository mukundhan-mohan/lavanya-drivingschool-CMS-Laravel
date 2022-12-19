@extends('layouts.global')

@section('title', 'Staffs')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 20);
}
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Staffs</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Staffs</a></div>
              <div class="breadcrumb-item">Staffs</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Staff Code</th>
                          <th>Mobile no</th>
                          <th>Email</th>
                          <th>Updated By</th>
                          <th>Present</th>
                          <th>Half day</th>
                          <th>Absent</th>
                        </tr>

                        @if(count($staffs) > 0)
                          @foreach($staffs as $index => $staff)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $staff->name}}</td>
                              <td>{{ $staff->staff_code}}</td>
                              <td>{{ $staff->mobile_no}}</td>
                              <td>{{ $staff->email}}</td>
                              <td>{{ $staff->updator_name}}</td>
                              <td><a href='javascript:;' onclick='updateAttendance("{{$staff->id}}","present");' class="btn btn-icon btn-lg btn-success"><span>P</span></a></td>
                              <td><a href='javascript:;' onclick='updateAttendance("{{$staff->id}}","half");' class="btn btn-icon btn-lg btn-info"><span>H</span></a></td> 
                              <td><a href='javascript:;' onclick='updateAttendance("{{$staff->id}}","absent");' class="btn btn-icon btn-lg btn-danger"><span>A</span></a></td>
                            </tr>
                            <tr>
                            @php
                            $numberStartWith++;
                          @endphp
                          @endforeach
                        @else
                          <tr>
                            <td colspan="6">No records found.</td>
                          </tr>
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block"> 
                       
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <form id="user_filter" autocomplete="off">
                    <div class="form-group" style="margin-top: 15px">
                        <label for="role" class="control-label col-lg-2 col-sm-4">Date Range</label>
                        <div class="col-lg-8 col-sm-8">
                            <input type="text" class="form-control daterangepickerinput"  
                              placeholder="Date Range" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                        </div> 
                        <div class="col-lg-2 col-sm-8">
                        <a href="{{ route('staffattendancepage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                        </div>
                    </div> 
                    </form>
                  <div class="card-header table-index">
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>Date</th>
                          @if(count($staffs) > 0)
                          @foreach($staffs as $index => $staff)
                          <th>{{$staff->name}}</th>
                          @endforeach
                          @endif
                          
                        </tr>

                        @if(count($attendancedates) > 0)
                          @foreach($attendancedates as $index => $attendancedate)
                            <tr id="">
                              <td>{{ $attendancedate->attendance_date}}</td>
                              <td>
                                @if( $attendancedate->tooltip($attendancedate->attendance_date , 1) )
                                  @if( ($attendancedate->tooltip($attendancedate->attendance_date , 1)->attendance_status) == "present")
                                  <span class="badge badge-success">Present</span>
                                  @elseif($attendancedate->tooltip($attendancedate->attendance_date , 1)->attendance_status == "half")
                                  <span class="badge badge-info">Half</span>
                                  @else
                                  <span class="badge badge-danger">Absent</span>
                                  @endif
                                @else
                                -
                                @endif
                              </td>
                              <td>
                                @if( $attendancedate->tooltip($attendancedate->attendance_date , 2) )
                                  @if( ($attendancedate->tooltip($attendancedate->attendance_date , 2)->attendance_status) == "present")
                                  <span class="badge badge-success">Present</span>
                                  @elseif($attendancedate->tooltip($attendancedate->attendance_date , 2)->attendance_status == "half")
                                  <span class="badge badge-info">Half</span>
                                  @else
                                  <span class="badge badge-danger">Absent</span>
                                  @endif
                                @else
                                -
                                @endif
                              </td>
                              <td>
                                @if( $attendancedate->tooltip($attendancedate->attendance_date , 3) )
                                  @if( ($attendancedate->tooltip($attendancedate->attendance_date , 3)->attendance_status) == "present")
                                  <span class="badge badge-success">Present</span>
                                  @elseif($attendancedate->tooltip($attendancedate->attendance_date , 3)->attendance_status == "half")
                                  <span class="badge badge-info">Half</span>
                                  @else
                                  <span class="badge badge-danger">Absent</span>
                                  @endif
                                @else
                                -
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="6">No records found.</td>
                          </tr>
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block"> 
                       
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
        </section>
    </div>


@endsection
<style>
    .table.table-md td {
    padding: 10px 15px;
    border-left: 1px solid rgba(0, 0, 0, 0.125);
}
.table.table-md th, .table.table-md td {
    border-left: 1px solid rgba(0, 0, 0, 0.125);
}
</style>

@section('js') 
<script>
function updateAttendance(staffid , status){
  if(confirm('Are you sure?'))
  {
    $(".global-popup-loader").show();
  $status = $('#'+staffid).val();
    $.ajax({
      url: baseurl+"/staff-attendance/"+staffid+"/stroreyed/"+status+"/save",
      method: 'GET',
      data: "",
      success: function(data){
        $(".global-popup-loader").hide();
      },
      error: function(e) {
          console.log(e);
          $(".global-popup-loader").hide();
      }

    });
  }
  
}
</script>
@endsection