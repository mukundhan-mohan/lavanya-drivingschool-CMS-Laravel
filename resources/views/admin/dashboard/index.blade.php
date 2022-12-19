@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
<!-- Main Content -->
<div class="main-content dashboard-section">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.llr_entries') }}</h4>
                   </div>
                  <div class="card-body">
                    {{$llr_entries}}
                  </div>
                </div>
                <a href="{{ route('licencepage') }}" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-th-large"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.enquiry_entries') }}</h4>
                   </div>
                  <div class="card-body">
                    {{$enquiry_entries}}
                  </div>
                </div>
                <a href="{{ route('enquirypage') }}" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-bell"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Balance Amount</h4>
                   </div>
                  <div class="card-body">
                   {{$balance_amount}}
                  </div>
                </div>
                <a href="" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-paw"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.none') }}</h4>
                   </div>
                  <div class="card-body">
                    23
                  </div>
                </div>
                <a href="" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-tint"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Oil Service</h4>
                   </div>
                  <div class="card-body">
                   {{ $vehicle_oil_service}}
                  </div>
                </div>
                <a href="{{ route('vehiclespage') }}" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-recycle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.forums') }}</h4>
                   </div>
                  <div class="card-body">
                    996
                  </div>
                </div>
                <a href="" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.files') }}</h4>
                   </div>
                  <div class="card-body">
                   36
                  </div>
                </div>
                <a href="" class="dashboard-links"></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 dashboard-links">
                <div class="card-icon bg-blue">
                  <i class="fa fa-tags"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>{{ __('message.navmenus.tags') }}</h4>
                   </div>
                  <div class="card-body">
                   5
                  </div>
                </div>
                <a href="" class="dashboard-links"></a>
              </div>
            </div>



          </div>

          
        </section>
</div>

@endsection

@section('js') 
@endsection