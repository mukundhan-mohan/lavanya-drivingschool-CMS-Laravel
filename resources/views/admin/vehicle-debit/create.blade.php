@extends('layouts.global')

@section('title', 'Debit')

@section('content')
@php
	$currentTab = "details";

@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Vehicle Debit</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('debitpage') }}">Debit</a></div>
              <div class="breadcrumb-item">Create Debit</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('vehicle-debit.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Debit</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Debit Amount in Rupees" type="text" name="amount" id="amount" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Vehicle</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select</option>
                                @foreach($vehicles as $key => $vehicle)
                                  <option value="{{  $vehicle->id }}" >{{ $vehicle->vechicle_no }}</option>
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Category</label>
                            <div class="col-lg-10 col-sm-8">
                                <select class="select2 form-control" id="cat_id" name="cat_id" required>
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
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Date of Debit" id="debit_date" name="created_at"  autocomplete="off"  style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="debit_date_formatted" name="debit_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Details</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Details about Debit" type="text" name="debit_details" id="debit_details" value="" required>
                            </div> 
                        </div>
                        <a href="javascript:;" id="first" onClick="test('debit_date');" class="btn btn-primary" style="display: none"></a>
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('vehicledebitpage') }}">
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
    function test(value){
        var contactdate = $('#'+value).val();
        var datetransform = contactdate.replaceAll("/", "-");
        var insurancedate = $('#'+value+'_formatted').val(datetransform);
        
        // alert(datetransform);
    }
    
    function clicked1(){
        $('#first')[0].click();
    }
    
    </script>
@endsection