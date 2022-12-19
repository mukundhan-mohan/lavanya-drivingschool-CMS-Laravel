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
        <h1>Add Notes</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
          <div class="breadcrumb-item">Add Notes</div>
        </div>
      </div>


      <div class="section-body horizontal-form ">
        @include('layouts.partials.alert')
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-primary">
            <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="version_id" id="version_id" value="">
                <input type="hidden" name="enquiry_id" id="enquiry_id" value="">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="role" class="control-label col-lg-2 col-sm-4">Notes</label>
                        {{-- <div class="col-lg-10 col-sm-8"> --}}
                            <textarea class="form-control" placeholder="Add Notes" type="text" name="notes" id="notes" value="" >{{ isset($allNotes) ? $allNotes->notes : ""}}</textarea>
                        {{-- </div>  --}}
                    </div>
                </div>
                {{-- <div class="card-footer text-right">
                    <a class="btn  btn-default" href="{{ route('notespage') }}">
                        Cancel
                    </a>
                    <input class="btn  btn-primary" id="create_button" type="submit" value="SAVE" >
                       
                </div> --}}
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

var typingTimer;                //timer identifier
        var doneTypingInterval = 100;  //time in ms, 5 second for example
        var $input = $('#notes');

        //on keyup, start the countdown
        $('#notes').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(saveNotes, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
        clearTimeout(typingTimer);
        });

        $('#notes').on('onclick', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(saveNotes, doneTypingInterval);
        });
        

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