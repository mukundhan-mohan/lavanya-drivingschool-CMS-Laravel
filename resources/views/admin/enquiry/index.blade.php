@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 20);
  $queryStrings = $_GET;
  $exportQueryStrings = $queryStrings;
  //$exporturl = URL::action('admin\CustomerEnquiryController@exportToCsv')."?".http_build_query($exportQueryStrings)."&";
}else{
  //$exporturl = URL::action('admin\CustomerEnquiryController@exportToCsv')."?";
  $exporturl = "";
}
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('message.navmenus.enquiry') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item" >{{ __('message.navmenus.enquiry') }}</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('exportToCsv') }}"
                      class="btn btn-primary note-btn" >Export Table</a>
                    <a href="{{ route('enquiry.create') }}" class="btn btn-success note-btn pull-right">+ {{ __('message.labels.add') }} Enquiry</a> 
                    <button type="button" class="btn btn-danger note-btn pull-right" data-toggle="modal" data-target="#staticBackdrop">DELETE RECORDS</button>
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Phone No</th>
                          <th>Version</th>
                          <th>class</th>
                          <th>Amount</th>
                          <th>Remark</th>
                          <th>Enquiry Date</th>
                          <!-- <th>Updated By</th> -->
                          <th>Status</th>
                          <!-- <th>Upated At</th> -->
                          <!-- <th>Created At</th> -->
                          <th >{{ __('message.labels.action') }}</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
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
                           <td>
                            </td>
                            <td></td>
                            @if(count($_GET) > 0)
                            <td> 
                              <a href="{{ route('enquirypage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                            </td>
                        @else
                          
                        @endif
                          </form>
                        </tr>

                        @if(count($CustomerEnqs) > 0)
                          @foreach($CustomerEnqs as $index => $CustomerEnq)
                            <tr id="">
                              <td>{{ $CustomerEnq->id}}</td>
                              <td>{{ $CustomerEnq->name}}</td>
                              <td>{{ $CustomerEnq->phone_number}}</td>
                              <td>{{ $CustomerEnq->version_name}}</td>
                              <td>{{ $CustomerEnq->no_of_classes}}</td>
                              <td>{{ $CustomerEnq->fees}}</td>
                              <td>{{ $CustomerEnq->remarks}}</td>
                              <td>{{ $CustomerEnq->EnquiryFormated}}</td>
                              <!-- <td>{{ $CustomerEnq->updator_name}}</td> -->
                              <td>
                                @if($CustomerEnq->is_joined == 1)
                                <span class="badge badge-success">Joined</span>
                                @else
                                -
                                @endif
                                </td>
                              <!-- <td>{{ $CustomerEnq->updatedAtFormated}}</td>  -->
                              <!-- <td>{{ $CustomerEnq->createdAtFormated}}</td> -->
                              <td style="display: flex;align-items: center">
                                @if($CustomerEnq->is_joined == 0)
                                <a href="{{ route('licence.create', [ 'enq_id' => $CustomerEnq->id ]) }}" class="btn btn-icon btn-sm btn-primary"><span>Join</span></a>
                                @endif
                                {{-- <a href="{{ route('enquiry.show', $CustomerEnq->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                 <a class="btn btn-icon btn-sm btn-danger" style="height: 20px;margin-left: 10px" onclick="deleteItem( '{{ $CustomerEnq->id }}' )" data-action="delete" 
                                        href="{{ URL::route('deleteEnquiry',$CustomerEnq->id) }}" id="delete_row_{{ $CustomerEnq->id }}" >
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
                      {{ $CustomerEnqs->appends($_GET)->links() }}
                  </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Records</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="delete_filter" autocomplete="off">
                  <div class="form-group" >
                    <div class="col-lg-12 col-sm-12">
                        <input type="text" class="form-control daterangepickerinput"  
                          placeholder="select date range to delete records" id="delete_range_records" name="delete_range_records" autocomplete="off">
                    </div> 
                  </div> 
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button onclick="submitForm('delete_filter')" class="btn btn-danger note-btn">Delete</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
    </div>


@endsection
<style>
  .daterangepicker .ltr .show-calendar .opensright{
    left: 984.38px !important;
  }
</style>
@section('js') 

<script type="text/javascript">
  function deleteSelectedRecords(){
    
  }
</script>
@endsection