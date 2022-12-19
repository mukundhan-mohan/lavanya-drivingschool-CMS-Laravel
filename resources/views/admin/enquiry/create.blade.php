@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Add {{ __('message.navmenus.enquiry') }}</h1>
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
                <form method="POST" action="{{ route('enquiry.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="">
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Version</label>
                            <div class="col-lg-10 col-sm-8">
                            <select class="select2 form-control" id="version_id" name="version_id" onchange="test(this.value)" required>
                                <option value="">Select</option>
                                @foreach($versions as $key => $version)
                                  <option value="{{  $version->id }}_{{$version->amount}}_{{$version->no_of_classes}}" {{ app('request')->input('version_id') == $version->id && app('request')->input('version_id') ? 'selected' : ''  }}>{{ $version->name }}</option>
                                  <!-- <label type="" id="amt_val" name="amt_value" value="{{$version->amount}}"> -->
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Amount</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Amount" type="text" name="amount" id="amount" value="" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">No of Classes</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="No of Classes" type="no_of_class" name="no_of_class" id="no_of_class" value="" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Name</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Name" type="name" name="name" id="name" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Phone Number</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="00 00 0000" type="tel" maxlength="10" name="phone_no" id="phone_no" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">E-Mail</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="E-Mail(optional)" type="email"  name="email" id="email" value="" >
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Address</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" placeholder="Address" type="address" name="address" id="address" value="" ></textarea>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Remark</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" placeholder="Remark" type="remark" name="remark" id="remark" value="" ></textarea>
                            </div> 
                        </div>
                        
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('enquirypage') }}">
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
<script type="text/javascript">
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
</script>

@endsection