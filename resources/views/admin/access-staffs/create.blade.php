@extends('layouts.global')

@section('title')
	Staff Create
@endsection

@section('content')
@php
	
	// $phoneCountryCodes = config('koala.select_with_null') + config('phnonecountrycodes.codes'); 
	// $statusoptions = config('koala.select_with_null') + config('koala.defaultstatusoptions');

	$roles = config('lavanya.select_with_null') + $roles;
	$title = "Staffs";
@endphp
	<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Staff</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    {!! Former::open_for_files()->action(route('adminstaffstore'))->method('POST')->setAttribute("onsubmit", "convertToProgress('create_button')") !!}
                    <div class="card-body">
                   
                      {!! Former::select('user_type')->label("Role")->options($roles)->class('select2')->required() !!}
                      {!! Former::text('name')->placeholder('Enter Name')->required() !!}
                      {!! Former::email('email')->placeholder('Enter Email')->required() !!}
                      {!! Former::password('password')->placeholder('Enter Password')->required() !!}
                      {!! Former::text('phone_number')->placeholder('Enter Phone Number')->required() !!}

                      <input type="hidden" name="has_other_address" id="has_other_address" value="0">
                   </div>
                   <div class="card-footer text-right">
                       <a href="{{ route('adminpermissions') }}">{!! Former::button('Cancel')->addClass('btn  btn-default') !!}</a>
                          {!! Former::submit('Create')->addClass('btn  btn-primary')->id('create_button') !!}
                   </div>
                      
                    {!! Former::close() !!}
				</div>
			</div>
		  </div>
		 </div>
	</section>
</div>

@endsection
<style>
    
</style>

@section('js')
<script type="text/javascript">
	$('#birthdate').datepicker({ format:'dd-mm-yyyy', footer: true, modal: true });
</script>
@endsection