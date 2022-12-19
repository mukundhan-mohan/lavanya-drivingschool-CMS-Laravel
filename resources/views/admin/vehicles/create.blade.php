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
            <h1>Add Vehicle</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('versionpage') }}">Vehicles</a></div>
              <div class="breadcrumb-item">Add Vehicle</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="vehicleId" id="vehicleId" value="{{ $vehicles?$vehicles->id : "" }}">
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Vehicle Number</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Vehicle Number" type="text" name="vehicle_no" id="vehicle_no" value="{{$vehicles?$vehicles->vechicle_no : ""}}" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Insurance Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Insurance Date " id="insurance_date" name="created_at"  autocomplete="off"  onchange="test('insurance_date')" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="insurance_date_formatted" name="insurance_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">FC Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select FC Date " id="fc_date" name="created_at"  autocomplete="off"  onchange="test()" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="fc_date_formatted" name="fc_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Next oil Service</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Next oil Service" id="next_oil_date" name="created_at"  autocomplete="off"  onchange="test()" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="next_oil_date_formatted" name="next_oil_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Next wheel balance</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Next wheel balance" id="next_wheel_date" name="created_at"  autocomplete="off"  onchange="test()" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="next_wheel_date_formatted" name="next_wheel_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Next water Service</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Next water Service" id="next_water_date" name="created_at"  autocomplete="off"  onchange="test()" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="next_water_date_formatted" name="next_water_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Next Battery Service</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Next Battery Service" id="next_battery_date" name="created_at"  autocomplete="off"  onchange="test()" style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="next_battery_date_formatted" name="next_battery_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Details</label>
                            <div class="col-lg-10 col-sm-8">
                            <input class="form-control" placeholder="Details" type="text" name="details" id="details" value="{{$title}}" >
                            </div> 
                        </div>
                        <a href="javascript:;" id="first" onClick="test('insurance_date');" class="btn btn-primary" style="display: none"></a>
                        <a href="javascript:;" id="second" onClick="test('fc_date');" class="btn btn-primary" style="display: none"></a>
                        <a href="javascript:;" id="third" onClick="test('next_oil_date');" class="btn btn-primary" style="display: none"></a>
                        <a href="javascript:;" id="fourth" onClick="test('next_wheel_date');" class="btn btn-primary" style="display: none"></a>
                        <a href="javascript:;" id="fifth" onClick="test('next_water_date');" class="btn btn-primary" style="display: none"></a>
                        <a href="javascript:;" id="sixth" onClick="test('next_battery_date');" class="btn btn-primary" style="display: none"></a>
                        
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('vehiclespage') }}">
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
    $('#second')[0].click();
    $('#third')[0].click();
    $('#fourth')[0].click();
    $('#fifth')[0].click();
    $('#sixth')[0].click();

}

</script>
@endsection