@extends('layouts.global')

@section('title')
	User Edit
@endsection

@section('content')
@php

	$roles = config('lavanya.select_with_null') + $roles;
	$roleId = 0;
	if($user->roles) {
		 $roleId = @$user->roles->first()->id;
	}
	$title = "Users";
	if(Auth::user()->isConciergeAdmin) {
	$title = "Inventory";
	}
@endphp
	<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $user->name }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
			<div class="breadcrumb-item"><a href="{{ route('adminpermissions') }}">Permissions</a></div>
              <div class="breadcrumb-item">{{ $user->name }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
				    {!! Former::open_for_files()->action(route('adminstaffupdate' ,[$user->id]))->method('POST')->setAttribute("onsubmit", "return isPassword('create_button')") !!}
				    {{-- {{ method_field('PATCH') }} --}}
				     <div class="card-body">
		
				       {!! Former::select('user_type')->label("Role")->options($roles)->class('select2')->select($roleId) !!}
				       {!! Former::text('Name')->placeholder('Enter Name')->value($user->name) !!}
				       {!! Former::email('email')->placeholder('Enter Email')->value($user->email) !!}
				       {!! Former::password('password')->placeholder('Enter Password') !!}
				       {!! Former::text('phone_number')->placeholder('Enter Phone Number')->value($user->phone_number) !!}

				    </div>
				    <div class="card-footer text-right">
				        <a href="{{ route('adminpermissions') }}">{!! Former::button('Cancel')->addClass('btn  btn-default') !!}</a>
				       	{!! Former::submit('Update')->addClass('btn  btn-primary')->id('create_button') !!}
				    </div>
				       
				     {!! Former::close() !!}
				</div>
			</div>
		  </div>
		 </div>
	</section>
</div>


<div id="showOTP" class="modal fade kola-modal show" role="dialog" style="padding-right: 15px; ">
    <div class="modal-dialog" id="dynamicManualPay">
        <form enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="list_form_serialize">
            <div class="modal-content horizontal-form">
                <div class="modal-header">
                    <img src="{{ url('images/sitelogo/brand-icon.svg') }}" class="modal-image">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Verify OTP</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group paymentgrp">
                        <label for="status" class="control-label col-lg-3 col-sm-8">OTP:</label>
                        <div class="col-lg-5 col-sm-4">
							<input type="text" name="otp" id="otp" placeholder="Code" class="form-control">

                            <p class="error-p display-none" id="es_message"></p>
                        </div>
                        <div class="col-lg-4 col-sm-4">
							<input type="hidden" name="otpverifylink" id="otpverifylink" value="0">
							<input type="button" name="verify" id="otpverify" value="Verify" class="btn btn-primary" onclick="verifyOtp()">
							
							<input type="button" name="resent_otp" id="resent_otp" value="Resend?" class="btn btn-primary" onclick="resentOTP()">
                        </div>
					</div>
					<div class="form-group paymentgrp">
						<span class="help-block">Otp has been sent to your email id.</span>
					</div>
                </div>
    
            </div>
        </form>
    </div>
</div>


@endsection

@section('js')
<script type="text/javascript">

	function  verifyOtp() {
		$("#otp").removeClass("has-error");
		$("#es_message").hide();
		$("#otpverifylink").val(0);
		var otp = $.trim($("#otp").val());
		if(otp == "") {
			$("#otp").addClass("has-error");
			return false;
		}
		$("#otpverify").addClass("btn-disabled").addClass("btn-progress");
        $.ajax({
            url: baseurl+"/access/staffs/{{ $user->id }}/verify/password",
            method: 'GET',
            data: "otp="+otp,
            success: function(data){
				console.log(data);
				$("#otpverify").removeClass("btn-disabled").removeClass("btn-progress");
				if(data.error == 1) {
					$("#es_message").show().html("Please enter valid otp");
					return false;
				}
				if(data.error == 0) {
					$("#showOTP").modal("hide");
					$("#otpverifylink").val(1);
					$("#create_button").click();
					return false;
				}
            },
            error: function(e) {
                console.log(e);
            }
		});
	}

	function resentOTP() {
		$("#resent_otp").addClass("btn-disabled").addClass("btn-progress");
		$(".help-block").hide();
        $.ajax({
            url: baseurl+"/access/staffs/{{ $user->id }}/password/change",
            method: 'GET',
            data: "",
            success: function(data){
				console.log(data);
				$(".help-block").show();
				$("#resent_otp").removeClass("btn-disabled").removeClass("btn-progress");
            },
            error: function(e) {
				console.log(e);
				$("#resent_otp").removeClass("btn-disabled").removeClass("btn-progress");
            }
		});
	}

	function isPassword(buttonId) {

		$("#"+buttonId).removeClass("btn-disabled").removeClass("btn-progress");
		var password = $.trim($("#password").val()) 
		if(password == "" || $("#otpverifylink").val() == 1) {
			$("#"+buttonId).addClass("btn-disabled").addClass("btn-progress");
			return true;
		}
		$("#"+buttonId).addClass("btn-disabled").addClass("btn-progress");
        $.ajax({
            url: baseurl+"/access/staffs/{{ $user->id }}/password/change",
            method: 'GET',
            data: "",
            success: function(data){
				console.log(data);
				$("#showOTP").modal("show");
				$("#"+buttonId).removeClass("btn-disabled").removeClass("btn-progress");
            },
            error: function(e) {
				console.log(e);
				$("#"+buttonId).removeClass("btn-disabled").removeClass("btn-progress");
            }
		});
		
		return false;
	}
</script>
@endsection