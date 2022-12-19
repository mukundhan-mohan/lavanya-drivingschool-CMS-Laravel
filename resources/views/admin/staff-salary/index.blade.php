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
            <h1>Staff Salary</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Staff Salary</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('staff-salary.create') }}" class="btn btn-primary note-btn pull-right">+ {{ __('message.labels.add') }} Staff Salary</a>                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Details</th>
                          <th>Created At</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                              
                              </td>
                            <td>
                              <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="amount" value="{{ app('request')->input('amount') }}" placeholder="Amount">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="name" value="{{ app('request')->input('name') }}" placeholder="Name">
                              
                            </td>
                            <td>
                                <select class="select2 form-control" id="cat_id" name="cat_id" onchange="submitForm('user_filter')">
                                    <option value="">Select</option>
                                    <option value="Salary">Salary</option>
                                    <option value="Advance">Advance</option>
                                    <option value="Balance">Balance</option>
                                    <option value="other">Other</option>
                                  </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="details" value="{{ app('request')->input('details') }}" placeholder="details">
                              
                            </td>
                            <td>
                                <input type="text" class="form-control daterangepickerinput"  
                              placeholder="Date Range" id="updated_range_quickfilter" name="updated_at" value="{{ ucfirst(app('request')->input('updated_at')) }}" autocomplete="off"  onchange="submitForm('user_filter')">
                              
                            </td>
                            
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('staffsalarypage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                            </td>
                            @endif
                          </form>
                        </tr>

                        @if(count($staffSalaries) > 0)
                          @foreach($staffSalaries as $index => $staffSalary)
                            <tr id="">
                              <td>{{ $staffSalary->id }}</td>
                              <td>{{ $staffSalary->date}}</td>
                              <td>{{ $staffSalary->debit}}</td>
                              <td>{{ $staffSalary->staff_name}}</td>
                              <td>{{ $staffSalary->category}}</td>
                              <td>{{ $staffSalary->details}}</td>
                              <td>{{ $staffSalary->createdAtFormated}}</td>
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
@endsection