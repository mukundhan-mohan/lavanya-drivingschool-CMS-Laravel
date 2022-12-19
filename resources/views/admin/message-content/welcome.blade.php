@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 50);
}
@endphp
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Welcome Message</h1>
        <div style="padding-left: 40px;">
          <button class="btn btn-success note-btn " onclick="enableDisableWelcome(1)">TURN ON</button>
          <button class="btn btn-danger note-btn " onclick="enableDisableWelcome(0)">TURN OFF</button>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
          <div class="breadcrumb-item">Welcome Message</div>
        </div>
      </div>


      <div class="section-body horizontal-form ">
        @include('layouts.partials.alert')
        <div class="row">
          <div class="col-6 col-md-7 col-lg-7">
            <div class="card card-primary">
            <form method="POST" action="{{ route('welcomeMessageStore') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="version_id" id="version_id" value="">
                <input type="hidden" name="enquiry_id" id="enquiry_id" value="">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="role" class="control-label col-lg-2 col-sm-4">Welcome Message</label>
                        {{-- <div class="col-lg-10 col-sm-8"> --}}
                            <textarea class="form-control" placeholder="Type a welcome Message" type="text" name="wcmsg" id="wcmsg" value="" >{{ isset($wcmsgCon) ? $wcmsgCon->content : ""}}</textarea>
                        {{-- </div>  --}}
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a class="btn  btn-default" href="{{ route('welcomemessage') }}">
                        Cancel
                    </a>
                    <input class="btn  btn-primary" id="create_button" type="submit" value="SAVE" >
                       
                </div>
                </form>
            </div>
        </div>
      </div>
     </div>
</section>
</div>


@endsection
<style>

   textarea {
        width:500px !important;
        height:450px !important;
    }
  </style>
@section('js') 
<script type="text/javascript">

function enableDisableWelcome(data)
{
  if(data == 0)
  {
    alert('Are you sure to "TURN OFF" welcome message');
  }else{
    alert('Are you sure to "TURN ON" welcome message');
  }
  $.ajax({
  url: "{{ route('enableDisable') }}",
  method: 'POST',
  data: "enOrdis="+data,
  success: function(data){
    // console.log(data);
        window.location.reload();
        // $("#search_result_ul").html(data);
      //$(".global-popup-loader").hide();
  },
  error: function(e) {
      console.log(e);
      //$(".global-popup-loader").hide();
  }

});
}

        function saveNotes()
        {
          var val = $.trim($("#notes").val());
          $.ajax({
		      url: "{{ route('notes.store') }}",
		      method: 'POST',
		      data: "notes="+val,
		      success: function(data){
		        console.log(data);
                
                $("#search_result_ul").html(data);
	            //$(".global-popup-loader").hide();
		      },
		      error: function(e) {
		          console.log(e);
	            //$(".global-popup-loader").hide();
		      }

		    });
        }
</script>
@endsection