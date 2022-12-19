@extends('layouts.global')

@section('title', 'Dashboard')

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
            <h1>Student Attendance</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Student Attendance</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <!-- <div class="card-header table-index">
                    <a href="{{ route('licence.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Licence</a>                    
                  </div> -->
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Account No</th>
                          <th>Name</th>
                          <!-- <th>Total classes</th> -->
                          <th>Attended</th>
                          <th>Vehicle</th>
                          {{-- <th>Balance</th> --}}
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="accnt_no" value="{{ app('request')->input('accnt_no') }}" placeholder="account no" >
                              </td>
                              <td>
                                  <select class="select2 form-control" id="name" name="name" onchange="submitForm('user_filter')" >
                                    <option value="">Select</option>
                                    @foreach($attendanceNames as $key => $attendanceName)
                                      <option value="{{  $attendanceName->id }}" {{ app('request')->input('name') == $attendanceName->id ? 'selected' : ''  }}>{{ $attendanceName->name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="attended" value="{{ app('request')->input('attended') }}" placeholder="attended">
                            </td>
                            <td>
                              <select class="select2 form-control" id="vehicle_id" name="vehicle_id" onchange="submitForm('user_filter')" >
                                <option value="">Select</option>
                                @foreach($vehicles as $key => $vehicle)
                                  <option value="{{  $vehicle->id }}"{{ app('request')->input('vehicle_id') == $vehicle->id ? 'selected' : ''  }} >{{ $vehicle->vechicle_no }}</option>
                                @endforeach
                              </select>
                              
                            </td>
                            {{-- <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="balance" value="{{ app('request')->input('balance') }}" placeholder="balance">
                            </td> --}}
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('attendancepage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                              
                            @endif
                          </form>
                        </tr>

                        @if(count($LicenceEnts) > 0)
                          @foreach($LicenceEnts as $index => $LicenceEnt)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $LicenceEnt->account_no}}</td>
                              <td>{{ $LicenceEnt->name}}</td>
                              <!-- <td>{{ $LicenceEnt->no_of_classes}}</td> -->
                              <!-- <td>{{ $LicenceEnt->attendances ? $LicenceEnt->attendances->no_of_classes : 'fresher' }}</td> -->
                              <td>
                                @if($LicenceEnt->attendedclasses)
                                   {{$LicenceEnt->attendedclasses}} / {{ $LicenceEnt->no_of_classes}}
                                @else
                                <span class="badge badge-warning">Fresher</span>
                                @endif
                              </td>
                              <td>{{ $LicenceEnt->vehiclename ? $LicenceEnt->vehiclename : '-' }}</td>
                              {{-- <td>{{ $LicenceEnt->student_balance ? $LicenceEnt->student_balance : '-' }}</td> --}}
                              <td>
                                <a href="{{ route('attendance.create', [ 'cus_id' => $LicenceEnt->id , 'enq_id' => $LicenceEnt->enquiry_id]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                {{-- <a href="{{ route('attendance.show', $LicenceEnt->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                              </td>
                            </tr>
                            <tr>
                            @php
                            $numberStartWith++;
                          @endphp
                          @endforeach
                        @else
                          <tr>
                            <td colspan="12">No records found.</td>
                          </tr>
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block "> 
                      {{ $LicenceEnts->appends($_GET)->links() }}
                  </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>


@endsection

@section('js') 
@endsection