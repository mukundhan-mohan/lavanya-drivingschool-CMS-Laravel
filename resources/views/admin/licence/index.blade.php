@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 50);
}
$filterURL = "";
     $hasSordOrderd = 0;
    if($_GET) {
        $fullUrl = url()->full()."&";
        $queryStrings = $_GET;
        $remove = ['version_sort'];
        if (strpos(url()->full(), '_sort') !== false) {
            $hasSordOrderd = 1;
        }
        $newQueryStrings = array_diff_key($queryStrings, array_flip($remove));
        $exportQueryStrings = $queryStrings;
        $filterURL =  URL::route('licencepage')."?".http_build_query($newQueryStrings)."&";
    }else {
        $filterURL =  URL::route('licencepage')."?";
    }
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('message.navmenus.licence') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">{{ __('message.navmenus.licence') }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('licence.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Licence</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Phone No</th>
                          <th style="display: flex">Version
                            <div class="arrow-fixation">
                              <a href="{{ $filterURL }}&version_sort=asc" class="filter {{ app('request')->input('version_sort') == 'asc' ? 'active' : '' }}"><i class="fas fa-arrow-up"></i></a>
                              <a href="{{ $filterURL }}&version_sort=desc" class="filter {{ app('request')->input('version_sort') == 'desc' ? 'active' : '' }}"><i class="fas fa-arrow-down"></i></a>
                              </div>
                          </th>
                          <th>class</th>
                          <th>Amount</th>
                          <th>Remark</th>
                          <!-- <th>Updated By</th> -->
                          <th>CreatedBy</th>
                          <!-- <th>Upated At</th> -->
                          <!-- <th>Created At</th> -->
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="id" value="{{ app('request')->input('id') }}" placeholder="ID" >
                              </td>
                            <td>
                                <select class="select2 form-control" id="name" name="name" onchange="submitForm('user_filter')" >
                                  <option value="">Select</option>
                                  @foreach($LicenceNames as $key => $LicenceName)
                                    <option value="{{  $LicenceName->id }}" {{ app('request')->input('name') == $LicenceName->id ? 'selected' : ''  }}>{{ $LicenceName->name }}</option>
                                  @endforeach
                                </select>
                              </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="phone_no" value="{{ app('request')->input('phone_no') }}" placeholder="Phone No">
                            </td>
                            <td>
                              <select class="select2 form-control" id="version_id" name="version_id" onchange="submitForm('user_filter')" >
                                <option value="">Select</option>
                                @foreach($versions as $key => $version)
                                  <option value="{{  $version->id }}" {{ app('request')->input('version_id') == $version->id ? 'selected' : ''  }}>{{ $version->name }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="classes" value="{{ app('request')->input('classes') }}" placeholder="classes">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="amount" value="{{ app('request')->input('amount') }}" placeholder="amount">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="remark" value="{{ app('request')->input('remark') }}" placeholder="remark">
                            </td>
                            <td></td>
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('licencepage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                              
                            @endif
                          </form>
                        </tr> 

                        @if(count($LicenceEnts) > 0)
                          @foreach($LicenceEnts as $index => $LicenceEnt)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $LicenceEnt->account_no}}</td>
                              <td>{{ $LicenceEnt->name}}</td>
                              <td>{{ $LicenceEnt->phone_number}}</td>
                              <td>{{ $LicenceEnt->version_name}}</td>
                              <td>{{ $LicenceEnt->no_of_classes}}</td>
                              <td>{{ $LicenceEnt->fees}}</td>
                              <td>{{ $LicenceEnt->remarks}}</td>
                              <td>{{ $LicenceEnt->creator_name}}</td>
                              <td>
                                <a href="{{ route('licence.create', [ 'cus_id' => $LicenceEnt->id , 'enq_id' => $LicenceEnt->enquiry_id]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                {{-- <a href="{{ route('licence.show', $LicenceEnt->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                 <a class="btn btn-icon btn-sm btn-danger" onclick="deleteItem( '{{ $LicenceEnt->id }}' )" data-action="delete" 
                                        href="{{ URL::route('deleteLicence',$LicenceEnt->id) }}" id="delete_row_{{ $LicenceEnt->id }}" >
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
                            <td colspan="12">No records found.</td>
                          </tr>
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block "> 
                      {{ $LicenceEnts->appends($_GET)->links() }}
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
<script src="assets/js/page/components-table.js"></script>
@endsection