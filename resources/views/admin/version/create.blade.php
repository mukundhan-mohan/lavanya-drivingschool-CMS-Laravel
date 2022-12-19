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
            <h1>Create {{ __('message.navmenus.version') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item"><a href="{{ route('versionpage') }}">{{ __('message.navmenus.version') }}</a></div>
              <div class="breadcrumb-item">Create {{ __('message.navmenus.version') }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                <form method="POST" action="{{ route('versionStore') }}" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
			        {{ csrf_field() }}
                    <input type="hidden" name="version_id" id="version_id" value="{{ $versionId }}">
				    <div class="card-body">
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Title</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Title" type="text" name="title" id="title" value="{{$title}}" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Amount</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="Amount" type="text" name="amount" id="amount" value="{{$amount}}" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label col-lg-2 col-sm-4">No of Classes</label>
                            <div class="col-lg-10 col-sm-8">
                                <input class="form-control" placeholder="No of Classes" type="no_of_class" name="no_of_class" id="no_of_class" value="{{$no_of_classes}}" required>
                            </div> 
                        </div>
                        
				       
				    </div>
				    <div class="card-footer text-right">
				        <a class="btn  btn-default" href="{{ route('versionpage') }}">
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
@endsection