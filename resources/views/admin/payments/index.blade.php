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
            <h1>Payments</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">{{ __('message.navmenus.dashboard') }}</a></div>
              <div class="breadcrumb-item">Payments</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    <form id="user_filter" autocomplete="off">
                        <div class="form-group" style="margin-top: 15px">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Account No</label>
                            <div class="col-lg-8 col-sm-8">
                                <input class="form-control" placeholder="Search" type="text"  name="account_pymnt" id="account_pymnt" value="" >
                            </div> 
                            <div class="col-lg-2 col-sm-8">
                            <a href='javascript:;' onclick='processAccountdata();' class="reset-btn note-btn ">Search</a>
                            </div>
                        </div> 
                        <div class="form-group" style="margin-top: 15px">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Name</label>
                            <div class="col-lg-8 col-sm-8">
                                {{-- <input class="form-control" placeholder="Search" type="text"  name="name_pymnt" id="name_pymnt" value="" > --}}
                                <select class="select2 form-control" id="name_pymnt" name="name_pymnt">
                                  <option value="">Select</option>
                                  @foreach($paymentsName as $key => $paymentsNames)
                                    <option value="{{  $paymentsNames->llr_id }}">{{ $paymentsNames->name }}</option>
                                  @endforeach
                                </select>
                            </div> 
                            <div class="col-lg-2 col-sm-8">
                            <a href='javascript:;' onclick='processNamedata();' class="reset-btn note-btn">Search</a>
                            </div>
                        </div> 
                        <div class="form-group" style="margin-top: 15px">
                            <label for="role" class="control-label col-lg-2 col-sm-4">Phone No</label>
                            <div class="col-lg-8 col-sm-8">
                                <input class="form-control" placeholder="Search" type="text"  name="phone_pymnt" id="phone_pymnt" value="" >
                            </div> 
                            <div class="col-lg-2 col-sm-8">
                            <a href='javascript:;' onclick='processPhonedata();' class="reset-btn note-btn">Search</a>
                            </div>
                        </div> 
                        </form>
                  <div class="card-header table-index">                    
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tbody><tr>
                          <th>#</th>
                          <th>Acc No</th>
                          <th>Name</th>
                          <th>Date</th>
                          <th>Bill No</th>
                          <th>Balance</th>
                          <th>Payment</th>
                          <th>pending amount</th>
                          <!-- <th>Updated By</th> -->
                          <!-- <th>Upated At</th> -->
                          <!-- <th>Created At</th> -->
                          <th style="width:140px;">{{ __('message.labels.action') }}</th>
                        </tr>
                        <tr>
                          <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td>
                                <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="accnt_no" value="{{ app('request')->input('accnt_no') }}" placeholder="account no" >
                            </td>
                            <td>
                                <select class="select2 form-control" id="name" name="name" onchange="{this.form.submit()}">
                                  <option value="">Select</option>
                                  @foreach($paymentsName as $key => $paymentsNames)
                                    <option value="{{  $paymentsNames->llr_id }}" {{ app('request')->input('name') == $paymentsNames->llr_id ? 'selected' : ''  }}>{{ $paymentsNames->name }}</option>
                                  @endforeach
                                </select>
                            </td>
                            <td>
                            </td>
                            <td>
                                <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="bill_no" value="{{ app('request')->input('bill_no') }}" placeholder="bill no" >
                            </td> 
                            <td>
                                <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="balance" value="{{ app('request')->input('balance') }}" placeholder="balance" >
                            </td> 
                            <td>
                                <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="payment" value="{{ app('request')->input('payment') }}" placeholder="payment" >
                            </td>
                           <td>
                            <input type="text" class="form-control"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                            name="pending_amount" value="{{ app('request')->input('pending_amount') }}" placeholder="pending amount" >
                            </td>
                            @if(count($_GET) > 0)
                                <td> 
                                  <a href="{{ route('paymentspage') }}" class="reset-btn note-btn">{{ __('message.labels.reset') }}</a>
                                </td>
                            @else
                              
                            @endif
                          </form>
                        </tr>

                        @if(count($payments) > 0)
                          @foreach($payments as $index => $payment)
                            <tr id="">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>{{ $payment->accnt_no}}</td>
                              <td>{{ $payment->name}}</td>
                              <td>{{ $payment->createdAtFormated}}</td>
                              <td>{{ $payment->accnt_no}}</td>
                              <td>{{ $payment->balance}}</td>
                              <td>{{ $payment->amount}}</td>
                              <td>{{ $payment->pending_amount}}</td>
                              <td>
                                {{-- <a href="{{ route('payments.create', [ 'cus_id' => $payment->llr_id , 'enq_id' => $payment->enquiry_id]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a> --}}
                                <a href="javascript:;" onclick="sms({{$payment->id}})" class=""><img alt="image" width="25%" src="{{ url('images/whatsapp.png') }}" class="rounded-circle mr-1"></a>
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
                      {{ $payments->appends($_GET)->links() }}
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
<script>
function sms(paymentId){
    $(".global-popup-loader").show();
      $.ajax({
        url: baseurl+"/payment/"+paymentId+"/sms",
        method: 'GET',
        data: "",
        success: function(data){
          $(".global-popup-loader").hide();
          alert(data);
        //   window.history.back();
        // console.log(data);
        // window.location.href = data.data;
        // window.history.back();
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });
}
function processAccountdata(){
    var account_no = $('#account_pymnt').val();
    // var name = $('#name_pymnt').val();
    // var phone_no = $('#phone_pymnt').val();

    $(".global-popup-loader").show();
      $.ajax({
        url: baseurl+"/payment/"+account_no+"/gotoPymnt",
        method: 'GET',
        data: "",
        success: function(data){
          $(".global-popup-loader").hide();
          console.log(data.data.llr_id);
          var customer_id = data.data.llr_id;
          var payment_id = data.data.id;
          window.location = baseurl+"/payments/create?cus_id="+customer_id+"&payment_id="+payment_id;
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });    
}
function processNamedata(){
    var name = $('#name_pymnt').val();
    $(".global-popup-loader").show();
      $.ajax({
        url: baseurl+"/payment/"+name+"/gotoPymntbyname",
        method: 'GET',
        data: "",
        success: function(data){
          $(".global-popup-loader").hide();
          console.log(data.data.llr_id);
          var customer_id = data.data.llr_id;
          var payment_id = data.data.id;
          window.location = baseurl+"/payments/create?cus_id="+customer_id+"&payment_id="+payment_id;
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });    
}
function processPhonedata(){
     var phone_no = $('#phone_pymnt').val();

    $(".global-popup-loader").show();
      $.ajax({
        url: baseurl+"/payment/"+phone_no+"/gotoPymntbyphone",
        method: 'GET',
        data: "",
        success: function(data){
          $(".global-popup-loader").hide();
          console.log(data.data.llr_id);
          var customer_id = data.data.llr_id;
          var payment_id = data.data.id;
          window.location = baseurl+"/payments/create?cus_id="+customer_id+"&payment_id="+payment_id;
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });    
}
</script>
@endsection