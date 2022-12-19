<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand" style="font-size: 20px;
    font-weight: bolder;
    color: #006488;">
            Lavanya Driving School
          </div>
          
          <ul class="sidebar-menu">
            @if(in_array('dashboard', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\DashboardController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('admindashboard') }}"><i class="fas fa-tachometer-alt"></i><span>{{ __('message.navmenus.dashboard') }}</span></a>
            </li>
            @endif

            @if(in_array('enquiry', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\CustomerEnquiryController@' )  ? 'active' : '' }}">
            <a href="{{ route('enquirypage') }}" class="nav-link"><i class="fa fa-th-large" aria-hidden="true"></i><span>{{ __('message.navmenus.enquiry') }}</span></a>
            </li>
            @endif

            @if(in_array('licence', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\LicenceEntriesController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('licencepage') }}"><i class="fa fa-book" aria-hidden="true"></i><span>{{ __('message.navmenus.licence') }}</span></a>
            </li>
            @endif

            @if(in_array('attendances', $tUserMenuP))
            <li class="dropdown {{  Str::contains(Route::currentRouteAction(), [ 'App\\Http\\Controllers\\Admin\\AttendancesController@', 'App\\Http\\Controllers\\Admin\\StaffAttendancesController@' ])  ? 'active' : '' }}">
              <a class="nav-link has-dropdown" href="{{ route('attendancepage') }}"><i class="fas fa-male" aria-hidden="true"></i><span>Attendances</span></a>
              <ul class="dropdown-menu">
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\AttendancesController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('attendancepage') }}"><i class="fas fa-circle"></i><span>Student</span></a>
                </li>
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\StaffAttendancesController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('staffattendancepage') }}"><i class="fas fa-circle"></i><span>Staff</span></a>
                </li>
              </ul>
            </li>
            @endif

            @if(in_array('payments', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\PaymentsController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('paymentspage') }}"><i class="fas fa-rupee-sign" aria-hidden="true"></i><span>{{ __('message.navmenus.payments') }}</span></a>
            </li>
            @endif

            @if(in_array('debit', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\DebitController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('debitpage') }}"><i class="fa fa-recycle" aria-hidden="true"></i><span>{{ __('message.navmenus.debit') }}</span></a>
            </li>
            @endif

            {{-- <li class="dropdown {{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\ForumsController@' )  ? 'active' : '' }}">
              <a class="nav-link has-dropdown" href=""><i class="fas fa-calculator" aria-hidden="true"></i><span>{{ __('message.navmenus.accounts') }}</span></a>
              <ul class="dropdown-menu">
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\ProjectCategoriesController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href=""><i class="fas fa-circle"></i><span>{{ __('message.navmenus.project_categories') }}</span></a>
                </li>
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\ProjectsController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href=""><i class="fas fa-circle"></i><span>{{ __('message.navmenus.projects') }}</span></a>
                </li>
              </ul>
            </li> --}}
            @if(in_array('fee-master', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\VersionController@')  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('versionpage') }}"><i class="fa fa-recycle" aria-hidden="true"></i><span>Fee Master</span></a>
            </li>
            @endif

            @if(in_array('vehicles', $tUserMenuP))
            <li class="dropdown {{  Str::contains(Route::currentRouteAction(), [ 'App\\Http\\Controllers\\Admin\\VehiclesController@', 'App\\Http\\Controllers\\Admin\\VehicleDebitController@', 'App\\Http\\Controllers\\Admin\\VehicleLogController@' ])  ? 'active' : '' }}">
              <a class="nav-link has-dropdown" href="{{ route('vehiclespage') }}"><i class="fas fa-car" aria-hidden="true"></i><span>Vehicles</span></a>
              <ul class="dropdown-menu">
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\VehiclesController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('vehiclespage') }}"><i class="fas fa-circle"></i><span>Vehicles</span></a>
                </li>
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\VehicleDebitController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('vehicledebitpage') }}"><i class="fas fa-circle"></i><span>Vehicle Debit</span></a>
                </li>
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\VehicleLogController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('vehiclelogpage') }}"><i class="fas fa-circle"></i><span>Vehicle Log Entry</span></a>
                </li>
              </ul>
            </li>
            @endif

            @if(in_array('staffs', $tUserMenuP))
            <li class="dropdown {{  Str::contains(Route::currentRouteAction(), [ 'App\\Http\\Controllers\\Admin\\StaffsController@', 'App\\Http\\Controllers\\Admin\\StaffSalaryController@' ])  ? 'active' : '' }}">
              <a class="nav-link has-dropdown" href="{{ route('staffspage') }}"><i class="fas fa-user-plus" aria-hidden="true"></i><span>Staffs</span></a>
              <ul class="dropdown-menu">
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\StaffsController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('staffspage') }}"><i class="fas fa-circle"></i><span>Staffs</span></a>
                </li>
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\StaffSalaryController@' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('staffsalarypage') }}"><i class="fas fa-circle"></i><span>Staff Salary</span></a>
                </li>
              </ul>
            </li>
            @endif

            @if(in_array('reports', $tUserMenuP))
            <li class="dropdown ">
              <a class="nav-link has-dropdown" href=""><i class="fa fa-file" aria-hidden="true"></i><span>Reports</span></a>
              <ul class="dropdown-menu">
                <li class="">
                  <a class="nav-link" href="{{ route('a2zpage') }}"><i class="fas fa-circle"></i><span>Master Report</span></a>
                </li>
                <li class="">
                  <a class="nav-link" href="{{ route('ledgerpage') }}"><i class="fas fa-circle"></i><span>Ledger Book</span></a>
                </li>
                <li class="">
                  <a class="nav-link" href="{{ route('a2zOriginal') }}"><i class="fas fa-circle"></i><span>A2z Report</span></a>
                </li>
              </ul>
            </li>
            @endif

            @if(in_array('notes', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\NotesController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('notespage')}}"><i class="fa fa-file" aria-hidden="true"></i><span>Notes</span></a>
            </li>
            @endif

            @if(in_array('msg-content', $tUserMenuP))
            <li class="dropdown {{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\MessageContentController@welcomemessage' )  ? 'active' : '' }}">
              <a class="nav-link has-dropdown" href=""><i class="fas fa-comment" aria-hidden="true"></i><span>Message Content</span></a>
              <ul class="dropdown-menu">
                <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\MessageContentController@welcomemessage' )  ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('welcomemessage') }}"><i class="fas fa-circle"></i><span>Welcome Message</span></a>
                </li>
              </ul>
            </li>
            @endif

            @if(in_array('activity-log', $tUserMenuP))
            <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\ActivityController@' )  ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('activitypage')}}"><i class="fa fa-shoe-prints" aria-hidden="true"></i><span>Activity Log</span></a>
            </li>
            @endif


            @if(auth()->user()->isAdmin)
              <li class="{{  str_contains(Route::currentRouteAction(), 'App\\Http\\Controllers\\Admin\\PermissionsController@' )  ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('adminpermissions')}}"><i class="fas fa-lock" aria-hidden="true"></i><span>Permissions</span></a>
              </li>
            @endif
            </ul>            
        </aside>
</div>