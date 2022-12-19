@extends('layouts.global')

@section('title')
	Permissions
@endsection

@section('css')

@endsection

@section('content')
@php
$curl = '';
$numberStartWith = 0;
if(app('request')->input('page') != "") {
  $numberStartWith = ( (app('request')->input('page') - 1 ) * 20);
}

$title = "Permissions";

@endphp
	<div class="main-content">
        <section class="section">
          <div class="section-header">
          <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admindashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item">{{ $title }}</div>
            </div>
          </div>

          
          <div class="section-body horizontal-form ">
            @include('layouts.partials.alert')
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header table-index">
                    <a href="{{ route('adminstaffcreate')  }}" class="btn btn-primary note-btn pull-right">+ Add New User</a>
                    @if(count($_GET) > 0)
                      <a href="{{ route('adminpermissions') }}" class="btn btn-danger note-btn pull-right">Clear Filters</a>
                    @endif
                  </div>
                	<div class="card-body p-0">
                    <div class="table-responsive tableFixHead">
                      <table class="table table-striped table-md">
                        <thead><tr>
                          <th>#</th>
                          <th>Actions</th>
                          <th>User</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Permissons</th>
                        </tr>
                        <tr>
                          {{-- <form id="user_filter" autocomplete="off">
                            <td></td>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" autocomplete="off"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                name="name" value="{{ app('request')->input('name') }}" placeholder="Name" ></td>
                            </td>
                            <td>
                              <input type="text" class="form-control" autocomplete="off"  onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" 
                                  name="email" value="{{ app('request')->input('email') }}" placeholder="Email">
                            </td>
                            <td>
                              <select class="select2" name="roleid" id="role_id"  onchange="submitForm('user_filter')" >
                                <option value="">Select</option>
                                @if($roles->count() > 0)
                                  @foreach($roles as $key => $role)
                                  <option value="{{ $role->id }}" {{ app('request')->input('roleid') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                  @endforeach
                                  
                                @endif
                            </select>
                            </td>
                            <td></td>
                          </form> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users) > 0)
                          @foreach($users as $index => $user)
                          @php
                          @endphp
                            <tr id="table_row_{{ $user->id }}">
                              <td>{{ $numberStartWith + 1 }}</td>
                              <td>
                                {{-- <a href="{{ route('adminstaffedit',[$user->id]) }}" class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                <a href="{{ route('adminstaffshow',[$user->id]) }}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                
                                <a class="btn btn-icon btn-sm btn-danger" onclick="deleteItem({{ $user->id }})" data-action="delete" 
                                  href="{{ URL::route('adminstaffdelete',$user->id) }}" id="delete_row_{{ $user->id }}" >
                                <i class="fas fa-times"></i>
                                </a>
                              </td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td class="role-dd" id="role_dd_{{ $user->id }}">
                                  <select class="select2" name="role_id" id="role_id_{{ $user->id }}" onchange="updateUserRole(this.value, '{{ $user->id }}')">
                                      <option value="">Select</option>
                                      @if($roles->count() > 0)
                                        @foreach($roles as $key => $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                        
                                      @endif
                                  </select>
                              </td>
                              <td>
                                <a href="{{ route('adminpermissionsmanage', $user->id) }}" class="btn btn-primary fixation" >Manage Access</a>
                              </td>
                            </tr>

                          @php
                            $numberStartWith++;
                          @endphp
                          @endforeach
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block"> 
                        {{ $users->appends($_GET)->links() }}
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
    function updateUserRole(role_id, user_id) {
        var htmlId = "role_dd_"+user_id;
        $(".role-dd").removeClass("has-error").removeClass("has-succes");
        if($.trim(role_id) == "") {
            $("#"+htmlId).addClass("has-error");
            return false;
        }
        $(".global-popup-loader").show();
        $.ajax({
            url: baseurl+"/permissions/"+user_id+"/change-role",
            method: 'GET',
            data: "role_id="+role_id,
            success: function(data){
            $(".global-popup-loader").hide();
                if(data.data == 0) {
                    alert("Something goes wrong. Please refresh and try again!");
                }else {
                    $("#"+htmlId).addClass("has-succes");
                }
            },
            error: function(e) {
                console.log(e);
                $(".global-popup-loader").hide();
                if(data.data == 0) {
                    alert("Something goes wrong. Please refresh and try again!");
                }
            }

        });
    }
</script>
@endsection