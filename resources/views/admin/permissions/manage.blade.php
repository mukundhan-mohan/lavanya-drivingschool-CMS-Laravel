@extends('layouts.global')

@section('title', "Manage Access")

@section('content')
<!-- Main Content -->
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Manage Access</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{ route('adminpermissions') }}">Permissions</a></div>
              <div class="breadcrumb-item"><a href="{{ route('adminstaffshow', $user->id) }}">{{ $user->name }} </a></div>
              <div class="breadcrumb-item">Manage Access</div>
            </div>
          </div>


          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary p-4 pt-0 ">
                  @foreach($groups as $key => $group)
                    <div class="row mt-3 mb-3">
                      <div class="col-3 col-md-3 col-lg-3">
                        <select name="access_on_off_left" onchange="toggleAccess('{{ $key }}', this.value)" class="form-control" id="access_group_{{ $key }}">
                          <option value="">Select</option>
                          <option value="1">Access On</option>
                          <option value="0">Access Off</option>
                        </select>
                      </div>
                      <div class="col-9 col-md-9 col-lg-9" id="menu_group_{{ $key }}">
                          @foreach($group as $menu)
                            <div class="row mb-2">
                              <div class="col-6 col-md-6 col-lg-6 menugroup">
                                <div class="icon">
                                  {!! $icons[$key] !!}
                                </div>
                                <div class="menu {{ !in_array($menu->id, $userMenus) ? 'off' : '' }} " id="menu_name_{{ $menu->id }}">
                                  {{ $menu->left_menu }}
                                </div>
                              </div>
                              <div class="col-6 col-md-6 col-lg-6">
                                <div class="access">
                                  <select name="access_on_off[{{ $key }}][{{ $menu->id }}]" data-id="{{ $menu->id }}" onchange="toggleAccessSingle(this.value, '{{ $menu->id }}', '{{ $key }}')"
                                    class="form-control {{ $key }} access-right" id="access_group_{{ $menu->id }}">
                                    <option value="1" {{ in_array($menu->id, $userMenus) ? 'selected' : '' }}>Access On</option>
                                    <option value="0"  {{ !in_array($menu->id, $userMenus) ? 'selected' : '' }}>Access Off</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          @endforeach
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          
        </section>
</div>
@endsection

@section('js') 
<script>

 

    function saveSettings(body) {
      $(".global-popup-loader").show();
        $.ajax({
            url: baseurl+"/permissions/{{ $user->id }}/save",
            method: 'POST',
            data: body,
            processData: false,
            contentType: false,
            success: function(data){
            $(".global-popup-loader").hide();
                $(".menu").addClass("off");
                if(data.data.length > 0) {
                  data.data.forEach(function( menuId ) {
                    $("#menu_name_"+menuId).removeClass("off");
                  });
                }

            },
            error: function(e) {
                console.log(e);
                $(".global-popup-loader").hide();
                console.log(data);
            }

        });
    }

    function toggleAccessSingle(value, menuId, groupId) {
    $("#access_group_"+groupId).val("");
    var formData = new FormData();
    formData.append("data["+menuId+"]", value);
    saveSettings(formData);
  }

  function toggleAccess(groupId, value) {
    if(value != "") {
      var formData = new FormData();
      $("#menu_group_"+groupId+" .access-right").each( function()  {
        $(this).val(value);
        var menuId = $(this).data('id');
        formData.append("data["+menuId+"]", value);
        
      });
      saveSettings(formData);
    }
  }
</script>
@endsection