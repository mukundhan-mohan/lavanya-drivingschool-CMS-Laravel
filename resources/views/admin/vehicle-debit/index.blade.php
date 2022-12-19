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
            <h1>Vehicle Debit</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Vehicle Debit</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('vehicle-debit.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Vehicle Debit</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Vehicle</th>
                          <th>Category</th>
                          <th>Amount</th>
                          <th>Details</th>
                          <th>Create At</th>
                        </tr>
                        <tr>
                            <form id="user_filter" autocomplete="off">
                              <td></td>
                              <td>
                                
                                </td>
                              <td>
                                <select class="select2 form-control" id="vehicle_id" name="vehicle_id" onchange="submitForm('user_filter')">
                                    <option value="">Select</option>
                                    @foreach($vehicles as $key => $vehicle)
                                      <option value="{{  $vehicle->id }}" >{{ $vehicle->vechicle_no }}</option>
                                    @endforeach
                                  </select>
                              </td>
                              <td>
                                <div class="col-lg-10 col-sm-8">
                                    <select class="select2 form-control" id="cat_id" name="cat_id" onchange="submitForm('user_filter')">
                                        <option value="">Select</option>
                                        <option value="Fuel">Fuel</option>
                                        <option value="Alignment">Alignment</option>
                                        <option value="Service">Service</option>
                                        <option value="Insurance">Insurance</option>
                                        <option value="oil service">Oil Service</option>
                                        <option value="Labour Tea Cmplx">Labour Tea Cmplx</option>
                                        <option value="alto+maruthi">alto+maruthi</option>
                                        <option value="Pollution">Pollution</option>
                                      </select>
                                </div> 
                              </td>
                              <td>
                                  <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="amount" value="{{ app('request')->input('amount') }}" placeholder="Amount">
                                
                              </td>
                              <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="details" value="{{ app('request')->input('details') }}" placeholder="Details">
                            </td>
                              <td>
                                  <input type="text" class="form-control daterangepickerinput"  
                                placeholder="Date Range" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                                
                              </td>
                              
                              @if(count($_GET) > 0)
                                  <td> 
                                    <a href="{{ route('vehicledebitpage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                  </td>
                              @else
                              </td>
                              @endif
                            </form>
                          </tr>

                        @if(count($VehicleDebits) > 0)
                          @foreach($VehicleDebits as $index => $VehicleDebit)
                            <tr id="">
                              <td>{{ $VehicleDebit->id }}</td>
                              <td>{{ $VehicleDebit->date}}</td>
                              <td>{{ $VehicleDebit->vehicle_name }}</td>
                              <td>{{ $VehicleDebit->category}}</td>
                              <td>{{ $VehicleDebit->debit}}</td>
                              <td>{{ $VehicleDebit->details}}</td>
                              <td>{{ $VehicleDebit->createdAtFormated}}</td>
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