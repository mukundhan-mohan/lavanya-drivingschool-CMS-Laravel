@extends('layouts.global')

@section('title', 'Staff Attendance')

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
            <h1>Staff </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item">Staffs</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('staffs.create') }}" class="btn btn-primary note-btn pull-right">+ ADD Staff</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Staff Code</th>
                          <th>Mobile no</th>
                          <th>Updated By</th>
                          <th>Created By</th>
                          <th>Upated At</th>
                          <th>Created At</th>
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>

                        @if(count($staffs) > 0)
                          @foreach($staffs as $index => $staff)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $staff->name}}</td>
                              <td>{{ $staff->staff_code}}</td>
                              <td>{{ $staff->mobile_no}}</td>
                              <td>{{ $staff->updator_name}}</td>
                              <td>{{ $staff->creator_name}}</td>
                              <td>{{ $staff->updatedAtFormated}}</td> 
                              <td>{{ $staff->createdAtFormated}}</td>
                              <td>
                                <a href="{{ route('staffs.create', [ 'staff_id' => $staff->id ]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                {{-- <a href="{{ route('staffs.show', $staff->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                 <a class="btn btn-icon btn-sm btn-danger" onclick="deleteItem( '{{ $staff->id }}' )" data-action="delete" 
                                        href="{{ URL::route('deleteStaff',$staff->id) }}" id="delete_row_{{ $staff->id }}" >
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
<style>
    .table.table-md td {
    padding: 10px 15px;
    border-left: 1px solid rgba(0, 0, 0, 0.125);
}
.table.table-md th, .table.table-md td {
    border-left: 1px solid rgba(0, 0, 0, 0.125);
}
</style>

@section('js') 
@endsection