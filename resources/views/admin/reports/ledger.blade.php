@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
@php
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 20);
}
$total_cred = $totalCredDeb->total_credit ? $totalCredDeb->total_credit : 4;
$total_debit = $totalCredDeb->total_debit ? $totalCredDeb->total_debit : 8;
@endphp
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Ledger Book</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">{{ __('message.navmenus.licence') }}</div>
              <input type="hidden" value="{{ $total_cred }}" id="total_cred">
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
                        <a href="{{ route('ledgerpage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                        </div>
                    </div> 
                    </form>
                    <div>
                        <div id="piechart"></div>
                    </div>
                  <div class="card-header table-index">
                    <button onclick="printDiv('ledgerTable')">Print this page</button>                   
                  </div>
                	<div class="card-body p-0" id="ledgerTable">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Entry Date</th>
                          <th>Particulars</th>
                          <th>Credit</th>
                          <th>Debit</th>
                        </tr>

                        @if(count($LicenceEnts) > 0)
                          @foreach($LicenceEnts as $index => $LicenceEnt)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $LicenceEnt->createdAtFormated}}</td>
                              <td>{{ $LicenceEnt->particulars}}</td>
                              <td>{{ $LicenceEnt->credit}}</td>
                              <td>{{ $LicenceEnt->debit}}</td>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['Credit', <?php echo $total_cred ?>],
  ['Debit', <?php echo $total_debit ?>]
  //['Sleep', <?php echo $LicenceEnt->payment_balance ?> ]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Ledger Report', 'width':700, 'height':400 , is3D: true};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
@endsection