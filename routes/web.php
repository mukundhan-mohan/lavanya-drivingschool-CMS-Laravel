<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::group( [ 'prefix' => '', 'namespace' => '', 'middleware' => [ 'auth'] ], function() {
	Route::group( [ 'prefix' => '', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => [ 'auth'] ], function() {

        Route::get('/', "DashboardController@index" )->name('home');

        Route::group( [ 'middleware' => 'permission:dashboard' ], function() {
        Route::get('/dashboard', "DashboardController@index" )->name('admindashboard');
        });

        Route::group( [ 'middleware' => 'permission:enquiry' ], function() {
        Route::resource('enquiry', 'CustomerEnquiryController');
        Route::get('/enquiry', "CustomerEnquiryController@index" )->name('enquirypage');
        Route::get("enquiry/{cust_id}/delete", "CustomerEnquiryController@delete")->name('deleteEnquiry');
        Route::get('/export/csv/enquiry', "CustomerEnquiryController@exportToCsv" )->name('exportToCsv');
        });

        
        Route::group( [ 'middleware' => 'permission:licence' ], function() {
        Route::resource('licence', 'LicenceEntriesController');
        Route::get('/licence', "LicenceEntriesController@index" )->name('licencepage');
        Route::get('/licence/{licence_id}/delete', "LicenceEntriesController@delete" )->name('deleteLicence');
        });

        Route::group( [ 'middleware' => 'permission:reports' ], function() {
        Route::get('/a2z', "LicenceEntriesController@a2z" )->name('a2zpage');
        Route::get('/ledger', "LicenceEntriesController@ledger" )->name('ledgerpage');
        Route::get('/a2zOriginal', "LicenceEntriesController@a2zOriginal" )->name('a2zOriginal');
        });


        Route::group( [ 'middleware' => 'permission:staffs' ], function() {
        Route::resource('staffs', 'StaffsController');
        Route::get('/staffs', "StaffsController@index" )->name('staffspage');
        Route::get("staff/{staff_id}/delete", "StaffsController@delete")->name('deleteStaff');
        Route::resource('staff-salary', 'StaffSalaryController');
        Route::get('/staff-salary', "StaffSalaryController@index" )->name('staffsalarypage');
        });

        Route::group( [ 'middleware' => 'permission:attendances' ], function() {
        Route::resource('attendance', 'AttendancesController');
        Route::get('/attendance', "AttendancesController@index" )->name('attendancepage');
        Route::resource('staff-attendance', 'StaffAttendancesController');
        Route::get('/staff-attendance', "StaffAttendancesController@index" )->name('staffattendancepage');
        Route::get("/staff-attendance/{staffId}/stroreyed/{status}/save", "StaffAttendancesController@saveattendance")->name('staffattendance');
        });

        Route::group( [ 'middleware' => 'permission:payments' ], function() {
        Route::resource('payments', 'PaymentsController');
        Route::get('/payments', "PaymentsController@index" )->name('paymentspage');
        Route::get("/payment/{paymentId}/sms", "PaymentsController@sms")->name('smspaymentdebt');
        Route::get("/payment/{accountId}/gotoPymnt", "PaymentsController@paymentrouteID")->name('paymentrouteeID');
        Route::get("/payment/{name}/gotoPymntbyname", "PaymentsController@paymentrouteNameID")->name('paymentrouteeNameID');
        Route::get("/payment/{phone_no}/gotoPymntbyphone", "PaymentsController@paymentroutePhoneID")->name('paymentrouteePhoneID');
        });

        Route::group( [ 'middleware' => 'permission:debit' ], function() {
        Route::resource('debit', 'DebitController');
        Route::get('/debit', "DebitController@index" )->name('debitpage');
        });

        Route::group( [ 'middleware' => 'permission:vehicles' ], function() {
                Route::resource('vehicles', 'VehiclesController');
                Route::get('/vehicles', "VehiclesController@index" )->name('vehiclespage');
                Route::resource('vehicle-debit', 'VehicleDebitController');
                Route::get('/vehicle-debit', "VehicleDebitController@index" )->name('vehicledebitpage');
                Route::resource('vehicle-log', 'VehicleLogController');
                Route::get('/vehicle-log', "VehicleLogController@index" )->name('vehiclelogpage');
                Route::get("/vehicle-log/{date}/stroreyed/{vehicle_id}/classes", "VehicleLogController@totalClasses")->name('totalclasses');
        });

        
        Route::group( [ 'middleware' => 'permission:activity-log' ], function() {
                Route::resource('activity', 'ActivityController');
                Route::get('/activity', "ActivityController@index" )->name('activitypage');
        });

        Route::group( [ 'middleware' => 'permission:notes' ], function() {
        Route::resource('notes', 'NotesController');
        Route::get('/notes', "NotesController@index" )->name('notespage');
        });

        Route::get('/sendSMS', "TwilioSMSController@index");


        Route::group( [ 'middleware' => 'permission:fee-master' ], function() {
        Route::resource('version', 'VersionController');
        Route::get('/version', "VersionController@index" )->name('versionpage');
        Route::get('/version/add', "VersionController@create" )->name('versionAddpage');
        Route::post('/version/storeyed', "VersionController@store" )->name('versionStore');
        Route::get("version/{site}/delete", "VersionController@delete")->name('deleteVersion');
        Route::get('/version/show', "VersionController@show" )->name('versionShowpage');
        });

        Route::group( [ 'middleware' => 'permission:msg-content' ], function() { 
                Route::get("/welcomemessage", "MessageContentController@welcomemessage")->name("welcomemessage");
                Route::POST("/welcomemessagestr", "MessageContentController@welcomeMessageStore")->name("welcomeMessageStore");
                Route::POST("/welcomemessageendis", "MessageContentController@enableDisable")->name("enableDisable");
        });

        Route::group( [ 'middleware' => 'permission:permissions' ], function() {
                Route::get("/permissions", "PermissionsController@index")->name("adminpermissions");
                Route::post("/permissions/{user}/save", "PermissionsController@save")->name("adminpermissionssave");
                Route::get("/permissions/{user}/manage", "PermissionsController@manage")->name("adminpermissionsmanage");
                Route::get("/permissions/{user}/change-role", "PermissionsController@changeRole")->name("adminpermissionschangerole");

                Route::get("/access-staffs/create", "PermissionsController@create")->name("adminstaffcreate");
                Route::post("/access/staffs/store", "PermissionsController@store")->name("adminstaffstore");
                Route::get("/access/staffs/{user}/edit", "PermissionsController@edit")->name("adminstaffedit");
                Route::post("/access/staffs/{user}/update", "PermissionsController@update")->name("adminstaffupdate");
                Route::get("/access/staffs/{user}", "PermissionsController@show")->name("adminstaffshow");
                Route::get("/access/staffs/{user}/delete", "PermissionsController@delete")->name("adminstaffdelete");
                Route::get("/access/staffs/{user}/password/change", "PermissionsController@passwordChange")->name("adminstaffpw");
                Route::get("/access/staffs/{user}/verify/password", "PermissionsController@verifyPw")->name("adminverifypw");
        });
// Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
// Route::get('login', [CustomAuthController::class, 'index'])->name('login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
//Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
});
});

