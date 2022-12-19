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
            <h1>{{ __('message.navmenus.version') }}</h1>
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
                    <a href="{{ route('version.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }}</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Title</th>
                          <th>Amount</th>
                          <th>Classes</th>
                          <th>Updated By</th>
                          <th>Created By</th>
                          <th>Upated At</th>
                          <th>Created At</th>
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>
                        

                        @if(count($Versions) > 0)
                          @foreach($Versions as $index => $version)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $version->name}}</td>
                              <td>{{ $version->amount}}</td>
                              <td>{{ $version->no_of_classes}}</td>
                              <td>{{ $version->updator_name}}</td>
                              <td>{{ $version->creator_name}}</td>
                              <td>{{ $version->updatedAtFormated}}</td>
                              <td>{{ $version->createdAtFormated}}</td>
                              <td>
                                <a href="{{ route('version.create', [ 'version_id' => $version->id ]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                <a href="{{ route('version.show', $version->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                 <a class="btn btn-icon btn-sm btn-danger" onclick="deleteItem( '{{ $version->id }}' )" data-action="delete" 
                                        href="{{ URL::route('deleteVersion',$version->id) }}" id="delete_row_{{ $version->id }}" >
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
                    <nav class="d-inline-block "> 
                      {{ $Versions->appends($_GET)->links() }}
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