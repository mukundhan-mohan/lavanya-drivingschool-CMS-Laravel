@extends('layouts.global')

@section('title', 'Dashboard')

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
            <h1>A2z Report</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">A2z Report</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    <form id="user_filter" autocomplete="off">
                        <div class="form-group" style="margin-top: 15px">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Date Range</label>
                            <div class="col-lg-8 col-sm-8">
                                <input type="text" class="form-control daterangepickerinput"  
                                  placeholder="{{ __('message.labels.updated_at') }}" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                            </div> 
                            <div class="col-lg-2 col-sm-8">
                            <a href="{{ route('a2zOriginal') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                            </div>
                        </div> 
                        </form>
                        
                            <div id="piechart"></div>
                     
                  <div class="card-header table-index">
                    <button onclick="printDiv('a2zTable')">Print this page</button>                   
                  </div>
                	<div class="card-body p-0" id="a2zTable">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Phone No</th>
                          <th>Version</th>
                          <th>class</th>
                          <th>Balance</th>
                          <!-- <th>Updated By</th> -->
                          <!-- <th>Upated At</th> -->
                          <!-- <th>Created At</th> -->
                        </tr>
                        {{-- <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="id" value="{{ app('request')->input('id') }}" placeholder="ID" >
                              </td>
                            <td>
                              <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="name" value="{{ app('request')->input('name') }}" placeholder="{{ __('message.labels.name') }}" >
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
                        </tr>  --}}

                        @if(count($LicenceEnts) > 0)
                          @foreach($LicenceEnts as $index => $LicenceEnt)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $LicenceEnt->account_no}}</td>
                              <td>{{ $LicenceEnt->name}}</td>
                              <td>{{ $LicenceEnt->phone_number}}</td>
                              <td>{{ $LicenceEnt->version_name}}</td>
                              <td>{{ $LicenceEnt->attended_classes ? $LicenceEnt->attended_classes : "0"}}</td>
                              <td>{{ $LicenceEnt->payment_balance ? $LicenceEnt->payment_balance : "0"}}</td>
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
<script  type="text/javascript">
   function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

@endsection