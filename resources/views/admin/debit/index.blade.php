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
            <h1>Debit</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Debit</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('debit.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Debit</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Debit</th>
                          <th>Details</th>
                          <th>Category</th>
                          <th>Created At</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              
                              </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="debit" value="{{ app('request')->input('debit') }}" placeholder="debit">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="details" value="{{ app('request')->input('details') }}" placeholder="details">
                              
                            </td>
                            <td>
                                <select class="select2 form-control" id="cat_id" name="cat_id" onchange="submitForm('user_filter')">
                                    <option value="">Select</option>
                                    <option value="personal">Personal</option>
                                    <option value="staff">Staff</option>
                                    <option value="vehicle">Vehicle</option>
                                    <option value="rto">RTO</option>
                                    <option value="other">Other</option>
                                  </select>
                            </td>
                            
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('debitpage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                             
                            @endif
                          </form>
                        </tr>

                        @if(count($debits) > 0)
                          @foreach($debits as $index => $debit)
                            <tr id="">
                              <td>{{ $debit->id }}</td>
                              <td>{{ $debit->date}}</td>
                              <td>{{ $debit->debit}}</td>
                              <td>{{ $debit->details}}</td>
                              <td>{{ $debit->category}}</td>
                              <td>{{ $debit->createdAtFormated}}</td>
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
                      {{ $debits->appends($_GET)->links() }}
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