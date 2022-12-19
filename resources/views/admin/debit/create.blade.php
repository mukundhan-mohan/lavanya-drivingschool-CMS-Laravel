@extends('layouts.global')

@section('title', 'Debit')

@section('content')
@php
	$currentTab = "details";
    $registration_date = date('d-m-Y');
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Debit</h1>
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
                <form method="POST" action="{{ route('debit.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Debit</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Debit Amount in Rupees" type="text" name="amount" id="amount" value="" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Category</label>
                            <div class="col-lg-10 col-sm-8">
                                <select class="select2 form-control" id="cat_id" name="cat_id" required>
                                    <option value="">Select</option>
                                    <option value="personal">Personal</option>
                                    <option value="staff">Staff</option>
                                    <option value="vehicle">Vehicle</option>
                                    <option value="rto">RTO</option>
                                    <option value="other">Other</option>
                                  </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Date</label>
                            <div class="col-lg-10 col-sm-8">
                            <input class="form-control"  type="text" name="debit_date_formatted" id="debit_date_formatted" value="{{$registration_date}}" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Details</label>
                            <div class="col-lg-10 col-sm-8">
                                <textarea class="form-control" style="height: 230px" placeholder="Details about Debit" type="text" name="debit_details" id="debit_details" value=""  rows="30" required></textarea>
                            </div> 
                        </div>
                        <a href="javascript:;" id="first" onClick="test('debit_date');" class="btn btn-primary" style="display: none"></a>
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('debitpage') }}">
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
</style>

@endsection

@section('js') 
<script  type="text/javascript">
    
    </script>
@endsection