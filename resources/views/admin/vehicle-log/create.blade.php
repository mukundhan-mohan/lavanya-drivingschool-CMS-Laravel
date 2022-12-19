@extends('layouts.global')

@section('title', 'Debit')

@section('content')
@php
	$currentTab = "details";

@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Vehicle Log</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Create Vehicle Log</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('vehicle-log.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Vehicle</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $key => $vehicle)
                                  <option value="{{  $vehicle->id }}" >{{ $vehicle->vechicle_no }}</option>
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input type="text" class="form-control daterangepickerinputsingle"  placeholder="Select Date of Entry" id="debit_date" name="created_at"  autocomplete="off"  style="margin-top: 5px;" data-lpignore="true" data-form-type="other">
                            <input type="hidden" id="debit_date_formatted" name="debit_date_formatted" value="">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Opening Km</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Enter Opening Km" onmouseover="clicked1();" onclick="totalclasses()" type="text" name="opening_km" id="opening_km" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Closing Km</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Enter Closing Km" type="text" name="closing_km" id="closing_km" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4" onmouseover="totalkm();">Total Km</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" onmouseover="totalkm()" type="text" name="total_km" id="total_km" value="" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Class</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control"  type="text" name="no_of_classes" id="no_of_classes" value="" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Details</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Details about Log" type="text" name="debit_details" id="debit_details" value="" >
                            </div> 
                        </div>
                        <a href="javascript:;" id="first" onClick="test('debit_date');" class="btn btn-primary" style="display: none"></a>
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('vehiclelogpage') }}">
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

    function totalkm(){
        var opening = $('#opening_km').val();
        var closing = $('#closing_km').val();
        if(opening != "" && closing!= ""){
                var total = closing - opening;
                $('#total_km').val(total);
        }
    }

    function totalclasses(){
        // alert("working");
        var date = $('#debit_date_formatted').val(); 
        var vehicle_id = $('#vehicle_id').val(); 
        $(".global-popup-loader").show();
        $.ajax({
            url: baseurl+"/vehicle-log/"+date+"/stroreyed/"+vehicle_id+"/classes",
            method: 'GET',
            data: "",
            success: function(data){
            $(".global-popup-loader").hide();
            console.log(data.data);
            var classesTotal = data.data;
            $('#no_of_classes').val(classesTotal);
            },
            error: function(e) {
                console.log(e);
                $(".global-popup-loader").hide();
            }

        });
        }

    function average(){
        
    }
    
    </script>
@endsection