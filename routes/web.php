<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('auth/login');
})->middleware('guest'); */

Route::middleware('guest')->group(function(){
    Route::get('/', function(){
        return view('auth/login');
    });
    Route::get('/user/profile-complete/{id}', 'UserController@completeProfile');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::middleware('auth')->group(function(){
    Route::get('/inventory', 'EquipmentController@index')->name('inventory');
    Route::get('/inventory/add', 'EquipmentController@presentAddNewBlade')->name('add-item');
    Route::get('/inventory/{code}', 'EquipmentController@show')->name('show-item');
    Route::get('/inventory/edit/{code}', 'EquipmentController@editEquipment')->name('edit-item');
    Route::get('/maintenance', 'MaintenanceController@presentUnscheduled')->name('maintenance');
    Route::get('/maintenance/history', 'MaintenanceController@presentHistoryTable')->name('history');
    Route::get('/maintenance/history/{code}', 'MaintenanceController@presentHistory')->name('history');
    Route::get('/maintenance/scheduled', 'MaintenanceController@plannedMaintenances')->name('scheduled');
    Route::get('/maintenance/scheduled/{code}', 'MaintenanceController@presentScheduledMaintenanceForm')->name('scheduled');
    Route::get('/profile', 'UserController@index')->name('profile');
    Route::get('/users', 'UserController@listAll')->name('users');
    Route::get('/users/add', 'UserController@addNew')->name('users');
    Route::post('/users/activate', 'UserController@is_active')->name('users');
    Route::get('/reports', 'RecordController@showReports')->name('reports');
    Route::get('/schedule', 'ScheduleController@index')->name('schedule');
    Route::get('/schedule/fetch_all', 'ScheduleController@fetchAll')->name('schedule');
    Route::get('/departments', 'DepartmentController@viewALl')->name('departments');
    Route::get('/department/{department}', 'DepartmentController@view')->name('department.view');
    Route::get('/units', 'UnitController@viewAll')->name('units');
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::get('/vendors', 'ServiceVendorController@index')->name('vendors');
    Route::get('/request-maintenance', 'RequestsController@index')->name('request');
    Route::get('/requests', 'RequestsController@viewAll')->name('request');
    Route::get('/markAsRead', 'NotificationController@markAllAsRead')->name('mark-as-read');
    Route::get('/approve', 'MaintenanceController@approve')->name('approve');
    Route::get('/categories', 'CategoryController@index')->name('categories');
    Route::get('/spare-parts', 'PartController@index')->name('spare-parts');
    Route::get('/spare-part/{part}', 'PartController@show')->name('spare-part.show');
});


    
Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');
    Route::get('/hospitals', 'HospitalController@index')->name('admin.hospitals');
    Route::get('/hospitals/add', 'HospitalController@addHospital')->name('admin.hospitals.add');
    Route::get('/hospitals/{code}', 'HospitalController@viewHospital')->name('admin.hospitals.view');
    Route::get('/hospitals/edit/{code}', 'HospitalController@updateHospital')->name('admin.hospitals.edit');
    Route::get('/districts', 'DistrictController@viewAll')->name('admin.districts');
    Route::get('/users', 'UserController@viewAll')->name('admin.users');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/equipment-types', 'CategoryController@index')->name('equipment-types');
    Route::get('/engineers', 'AdminController@showEngineers')->name('show-engineers');
    Route::get('/engineers/add', 'AdminController@addEngineer')->name('add-engineer');
    Route::get('/requests', 'RequestsController@adminIndex')->name('requests');
    Route::get('/assigned', 'RequestsController@presentEngineerJobs')->name('assigned');
    Route::get('/assigned/maintenance/{equipment}/{job}', 'RequestsController@handleMaintenance')->name('request.maintenance');
    Route::get('/approve', 'MaintenanceController@adminApprovals')->name('admin-approve');
    Route::get('/markAsRead', 'NotificationController@markAllAsRead')->name('mark.read');
});


Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
