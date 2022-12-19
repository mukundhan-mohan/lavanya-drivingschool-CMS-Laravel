@if(session()->has('success'))
<div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>×</span>
      </button>
      {{ session()->get('success') }}
    </div>
 </div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>×</span>
      </button>
      {{ session()->get('error') }}
    </div>
</div>
@endif