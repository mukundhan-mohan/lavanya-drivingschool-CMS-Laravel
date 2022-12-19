@extends('layouts.global')

@section('title', 'Vehicles')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 20);
}
@endphp

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Vehicles</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">{{ __('message.navmenus.version') }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Vehicle</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Vehicle</th>
                          <th>Insurance Date</th>
                          <th>Fc Date</th>
                          <th>Updated By</th>
                          <th>Created By</th>
                          <th>Upated At</th>
                          <th>Created At</th>
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>
                        <!-- <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="name" value="{{ app('request')->input('name') }}" placeholder="{{ __('message.labels.name') }}" >
                              </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="email" value="{{ app('request')->input('email') }}" placeholder="{{ __('message.labels.email') }}">
                            </td>
                            <td>
                              <select class="select2 form-control" id="role" name="role" onchange="submitForm('user_filter')" >
                                <option value="0">Select</option>
                               
                              </select>
                              
                            </td>
                            <td>
                              <select class="select2 form-control" id="site_id" name="site_id" onchange="submitForm('user_filter')" >
                                <option value="0">Select</option>
                               
                              </select>
                            </td>
                            <td>
                              <select class="select2 form-control" id="status" name="status" onchange="submitForm('user_filter')" >
                               
                              </select>
                            </td>
                           <td>
                              <input type="text" class="form-control daterangepickerinput"  
                                placeholder="{{ __('message.labels.created_at') }}" id="created_range_quickfilter" name="created_at" value="{{ ucfirst(app('request')->input('created_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                            </td>

                            <td>
                              <input type="text" class="form-control daterangepickerinput"  
                              placeholder="{{ __('message.labels.updated_at') }}" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                            </td>
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('users.index') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                              <td></td>
                            @endif
                          </form>
                        </tr> -->

                        @if(count($vehicles) > 0)
                          @foreach($vehicles as $index => $vehicle)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $vehicle->vechicle_no}}</td>
                              <td>{{ $vehicle->insurance_date}}</td>
                              <td>{{ $vehicle->fc_date}}</td>
                              <td>{{ $vehicle->updator_name}}</td>
                              <td>{{ $vehicle->creator_name}}</td>
                              <td>{{ $vehicle->updatedAtFormated}}</td>
                              <td>{{ $vehicle->createdAtFormated}}</td>
                              <td>
                                <a href="{{ route('vehicles.create', [ 'vehicle' => $vehicle->id ]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                {{-- <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                 <a class="btn btn-icon btn-sm btn-danger" onclick="deleteItem( '{{ $vehicle->id }}' )" data-action="delete" 
                                        href="" id="delete_row_{{ $vehicle->id }}" >
                                      <i class="fas fa-times"></i>
                                   </a>
                              </td>
                            </tr>
                            <tr>
                            @php
                            $numberStartWith++;
                          @endphp
                          @endforeach
                        @else
                          <tr>
                            <td colspan="6">No records found.</td>
                          </tr>
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block"> 
                       
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>

@endsection

@section('js') 
@endsection