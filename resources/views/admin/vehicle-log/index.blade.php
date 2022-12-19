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
            <h1>Vehicle Log Entry</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Vehicle Log Entry</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('vehicle-log.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Vehicle Log</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>ID</th>
                          <th>Vehicle</th>
                          <th>Date</th>
                          <th>Opening Km</th>
                          <th>Closing Km</th>
                          <th>Total Km</th>
                          <th>Classes</th>
                          <th>Average</th>
                          <th>Excess Km</th>
                          <th>Created At</th>
                        </tr>
                        <tr>
                            <form id="user_filter" autocomplete="off">
                              <td></td>
                              <td>
                                <select class="select2 form-control" id="vehicle_id" name="vehicle_id" onchange="submitForm('user_filter')">
                                    <option value="">Select</option>
                                    @foreach($vehicles as $key => $vehicle)
                                      <option value="{{  $vehicle->id }}" >{{ $vehicle->vechicle_no }}</option>
                                    @endforeach
                                  </select>
                              </td>
                              <td>
                              </td>
                              <td>
                                  <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="opening_km" value="{{ app('request')->input('opening_km') }}" placeholder="Opening Km">
                                
                              </td>
                              <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="closing_km" value="{{ app('request')->input('closing_km') }}" placeholder="Closing Km">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="total_km" value="{{ app('request')->input('total_km') }}" placeholder="Total Km">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="no_of_classes" value="{{ app('request')->input('no_of_classes') }}" placeholder="Classes">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="average" value="{{ app('request')->input('average') }}" placeholder="Average">
                            </td>
                              <td>
                                  <input type="text" class="form-control daterangepickerinput"  
                                placeholder="Date Range" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                                
                              </td>
                              <td>
                              </td>
                              
                              @if(count($_GET) > 0)
                                  <td> 
                                    <a href="{{ route('vehiclelogpage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                  </td>
                              @else
                              </td>
                              @endif
                            </form>
                          </tr>

                        @if(count($vehicleLogs) > 0)
                          @foreach($vehicleLogs as $index => $vehicleLog)
                            <tr id="">
                              <td>{{ $vehicleLog->id }}</td>
                              <td>{{ $vehicleLog->vehicle_name }}</td>
                              <td>{{ $vehicleLog->entry_date}}</td>
                              <td>{{ $vehicleLog->opening_km}}</td>
                              <td>{{ $vehicleLog->closing_km}}</td>
                              <td>{{ $vehicleLog->total_km}}</td>
                              <td>{{ $vehicleLog->no_of_classes}}</td>
                              <td>{{ $vehicleLog->average}}</td>
                              <td>{{ ($vehicleLog->total_km - $vehicleLog->no_of_classes*6) }}</td>
                              <td>{{ $vehicleLog->createdAtFormated}}</td>
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
        </section>
    </div>

@endsection

@section('js') 
@endsection