@extends('layouts.global')

@section('title')
	 {{ $version->name }}
@endsection

@section('content')
@php
	
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $version->name }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{ route('versionpage') }}">{{ __('message.navmenus.sites') }}</a></div>
              <div class="breadcrumb-item">{{ $version->name }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
       
	                  

                <div class="card author-box displayflex card-primary">
                	<div class="card-header table-index">
                    	<a href="{{ route('versionAddpage', ['version_id' => $version->id]) }}" class="btn btn-primary note-btn pull-right">Edit</a>
                    	<a href="{{ route('versionpage') }}" class="pull-right">Cancel
                    	</a>
                  	</div>
                  			<div class="card-body table-responsive">
                				<table class="table table-striped table-md">
                					<tr>
		                        		<th>Title</th>
		                        		<th>:</th>
		                        		<td>{{ $version->name }}</td>
		                        	</tr>
		                        	<tr>
		                        		<th>Amount</th>
		                        		<th>:</th>
		                        		<td>{{ $version->amount }}</td>
		                        	</tr>
		                        	<tr>
		                        		<th>No of Classes</th>
		                        		<th>:</th>
		                        		<td>{{$version->no_of_classes}}</td>
		                        	</tr>
		                        	<tr>
		                        		<th>{{ __('message.labels.created_at') }}</th>
		                        		<th>:</th>
		                        		<td>{{ $version->created_at }}</td>
		                        	</tr>
		                        	<tr>
		                        		<th>{{ __('message.labels.updated_at') }}</th>
		                        		<th>:</th>
		                        		<td>{{ $version->updated_at }}</td>
		                        	</tr>
                				</table>
                			</div>

		                	 
				        	</div>
				        	<?php /*
				        	 <div class="card-header">
			                    <h2 class="make-a-to-right"><strong>Directors</strong></h2>
			                  </div>
			                  <div class="card">
				                  <div class="card-body">
				                    <div id="accordion" class="full-width">
				                    	@if(count($directors) > 0)
				                    		@foreach($directors as $key => $director)
						                    	<div class="accordion">
								                    <div class="accordion-header collapsed" role="button" id="unit_type_panel" 
								                    data-toggle="collapse" data-target="#panel-body-{{ $director->id }}" aria-expanded="false">
									                    <h4 class="make-a-to-right"><strong>{{ ($key + 1) }}. {{ $director->name }}</strong>
									                    	<a class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye white"></i></a>
									                    </h4>

									                </div>
									            </div>
									             <div class="accordion-body collapse table-responsive" id="panel-body-{{ $director->id }}" 
									             	data-parent="#accordion" style="">
						                          	<table class="table table-striped table-md">
							                        	<tr>
							                        		<th>First Name</th>
							                        		<th>:</th>
							                        		<td>{{ $director->first_name }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Last Name</th>
							                        		<th>:</th>
							                        		<td>{{ $director->last_name }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Avatar</th>
							                        		<th>:</th>
							                        		<td>
							                        			@if($director->avatar)
							                        				<img src="{{ $director->imageThumbnail }}" width="100">
							                        			@endif
							                        		</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Email</th>
							                        		<th>:</th>
							                        		<td>{{ $director->email }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Phone number</th>
							                        		<th>:</th>
							                        		<td>{{ $director->phoneNumberFormated }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Position</th>
							                        		<th>:</th>
							                        		<td>{{ $director->position }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Expertise</th>
							                        		<th>:</th>
							                        		<td>{{ $director->expertise }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Clinic Profile</th>
							                        		<th>:</th>
							                        		<td>{{ $director->clinic_profile }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Traveler Profile</th>
							                        		<th>:</th>
							                        		<td>{{ $director->traveler_profile }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Affiliation</th>
							                        		<th>:</th>
							                        		<td>{{ $director->affiliation }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Country</th>
							                        		<th>:</th>
							                        		<td>{{ $director->country }}</td>
							                        	</tr>
							                        	<tr>
							                        		<th>Set As Primary</th>
							                        		<th>:</th>
							                        		<td>{{ $director->primaryReable }}</td>
							                        	</tr>
							                        </table>
								                 </div>
								            @endforeach
							            @endif
				                    </div>
				                  </div>
				</div>
				*/ ?>
					

			  </div>
			</div>
		</div>
	</section>
</div>
@endsection


@section('scripts')

@endsection