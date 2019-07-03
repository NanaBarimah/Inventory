<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/complete-profile', 'UserController@complete');

Route::middleware('auth:api')->group(function(){
    Route::get('users/', 'UserController@index');
    Route::post('users/add_user', 'UserController@store');
    Route::get('users/{user}', 'UserController@show');
    Route::put('users/update/{user}', 'UserController@update');
    Route::put('users/activate', 'UserController@is_active');
    Route::post('users/user-login', 'UserController@userLogin');

    Route::post('asset-category/add', 'AssetCategoryController@store');
    Route::post('fault-category/add', 'FaultCategoryController@store');
    Route::post('priority/add', 'PriorityController@store');
    Route::post('part-category/add', 'PartCategoryController@store');

    Route::put('asset-category/update/{assetCategory}', 'AssetCategoryController@update');
    Route::put('fault-category/update/{faultCategory}', 'FaultCategoryController@update');
    Route::put('part-category/update/{partCategory}', 'PartCategoryController@update');
    Route::put('priority/update/{priority}', 'PriorityController@update');

    Route::post('spare-part/add', 'PartController@store');
    Route::put('spare-part/update/{part}', 'PartController@update');
    
    Route::get('assets/{hospital}', 'AssetController@get');
    Route::post('asset/add', 'AssetController@store');
    Route::put('asset/{asset}/update', 'AssetController@update');
    Route::delete('asset/{asset}/delete', 'AssetController@delete');
    Route::get('asset/{asset}/get-parts', 'AssetController@getParts');
    Route::get('asset/{asset}/get-files', 'AssetController@getFiles');
    Route::get('asset/{asset}/get-children', 'AssetController@getChildren');
    Route::get('asset/{asset}/depreciation', 'AssetController@depreciation');
    Route::post('asset/{asset}/toggle', 'AssetController@toggle');
    Route::post('asset/{asset}/remove-part', 'AssetController@removePart');
    Route::post('asset/{asset}/assign-parts', 'AssetController@assignPart');
    Route::post('asset/{asset}/remove-child', 'AssetController@removeChild');
    Route::post('asset/{asset}/assign-children', 'AssetController@assignChild');

    Route::post("purchase-order/add", 'PurchaseOrderController@store');
    Route::post("purchase-order/{purchaseOrder}/update", 'PurchaseOrderController@update');
    Route::post("purchase-order/{purchaseOrder}/send", 'PurchaseOrderController@sendLink');
    Route::post("purchase-order/{purchaseOrder}/approve", 'PurchaseOrderController@approve');
    Route::post("purchase-order/{purchaseOrder}/decline", 'PurchaseOrderController@decline');
    Route::post("purchase-order/{purchaseOrder}/fulfill", 'PurchaseOrderController@fulfill');
    
    Route::post('file/add', 'FileController@store');
    
    Route::get('equipment/{equipment}', 'EquipmentController@show');
    Route::put('equipment/update/{equipment}', 'EquipmentController@update');

    Route::post('departments/add', 'DepartmentController@store');
    Route::put('departments/update/{department}', 'DepartmentController@update');

    Route::post('units/add', 'UnitController@store');
    Route::put('units/update/{unit}', 'UnitController@update');

    Route::post('requests/add', 'RequestsController@store');
    Route::put('request/{work_request}/decline', 'RequestsController@decline');
    Route::put('request/{work_request}/approve', 'RequestsController@approve');
    Route::put('request/{work_request}/update', 'RequestsController@update');

    Route::post("work-order/add", "WorkOrderController@store");
    Route::get("work-order/available-technicians/{workOrder}", "WorkOrderController@availableTechnicians");
    Route::post("work-order/{workOrder}/assign-team", "WorkOrderController@assignTeam");
    Route::post("work-order/{workOrder}/record-activity", "WorkOrderController@recordActivity");
    Route::post("work-order/{workOrder}/comment", "WorkOrderController@comment");
    Route::get("work-order/{workOrder}/comments", "WorkOrderController@getComments");
    Route::put("work-order/{workOrder}/assign-asset", "WorkOrderController@assignAsset");
    Route::get("work-order/{workOrder}/activities", "WorkOrderController@getActivities");
    Route::get("work-order/{workOrder}/spare-parts", "WorkOrderController@getSpareParts");
    Route::post("work-order/{workOrder}/add-part", "WorkOrderController@attachSpareParts");
    Route::post("work-order/{workOrder}/update-status", "WorkOrderController@updateStatus");
    Route::post("work-order/{workOrder}/complete", "WorkOrderController@complete");

    Route::post('schedule/add', 'ScheduleController@store');

    Route::post('settings/{hospital_id}/generate-link', 'SettingController@generateRequestLink');
    Route::post('settings/{hospital_id}/send-link', 'SettingController@generateRequestLink');

    Route::post('vendors/add', 'ServiceVendorController@store');
    Route::put('vendors/update/{vendor}', 'ServiceVendorController@update');

});

Route::middleware('passport:admin-api')->group(function(){
    Route::get('admins/', 'AdminController@index');
    Route::post('admins/add_admin', 'AdminController@store');
    Route::get('admins/{admin}', 'AdminController@show');
    Route::put('admins/update/{admin}', 'AdminController@update');
    Route::post('admins/admin-login', 'Auth\AdminLoginController@adminLogin');
    Route::put('admins/activate', 'AdminController@is_active');

    Route::get('regions/', 'RegionController@index');
    Route::post('regions/add_region', 'RegionController@store');
    Route::get('regions/{region}', 'RegionController@show');
    Route::put('regions/update/{region}', 'RegionController@update');

    Route::get('districts/', 'DistrictController@index');
    Route::post('districts/add_district', 'DistrictController@store');
    Route::get('districts/{district}', 'DistrictController@show');
    Route::put('districts/update/{district}', 'DistrictController@update');

    Route::get('hospitals/', 'HospitalController@index');
    Route::post('hospitals/add_hospital', 'HospitalController@store');
    Route::get('hospitals/{hospital}', 'HospitalController@show');
    Route::put('hospitals/update/{hospital}', 'HospitalController@update');
    Route::put('hospitals/settings', 'HospitalController@updateSettings');

    Route::get('maintenances/', 'MaintenanceController@index');
    Route::post('admin/maintenances/add', 'MaintenanceController@store');
    Route::get('admin/maintenances/{maintenance}', 'MaintenanceController@show');
    Route::put('admin/maintenances/update/{maintenance}', 'MaintenanceController@update');
    Route::post('admin/maintenances/report/cummulative', 'MaintenanceController@getCummulativeReport');
    Route::post('admin/maintenances/report/categorized', 'MaintenanceController@getCategorizedReport');
    Route::post('admin/maintenances/report/unit', 'MaintenanceController@getUnitReport');
    Route::post('admin/maintenances/report/department', 'MaintenanceController@getDepartmentReport');
    Route::post('admin/maintenances/report/cost/month', 'MaintenanceController@costPerMonth');
    Route::post('admin/maintenances/report/cost/type', 'MaintenanceController@costPerType');
    Route::post('admin/maintenances/report/cost/unit', 'MaintenanceController@costPerUnit');
    Route::post('admin/maintenances/report/cost/department', 'MaintenanceController@costPerDepartment');
    Route::put('admin/maintenances/admin-approve', 'MaintenanceController@adminApprove');

    Route::put('requests/assign/{request}', 'RequestsController@assign');   
});

// route for issue tokens
Route::group(['middleware' => ['passport:admin-api']], function() {
    Route::post('/token1', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
});

    Route::post('maintenances/report/cummulative', 'MaintenanceController@getCummulativeReport');
    Route::post('maintenances/report/categorized', 'MaintenanceController@getCategorizedReport');
    Route::post('maintenances/report/unit', 'MaintenanceController@getUnitReport');
    Route::post('maintenances/report/department', 'MaintenanceController@getDepartmentReport');
    Route::post('maintenances/report/cost/month', 'MaintenanceController@costPerMonth');
    Route::post('maintenances/report/cost/type', 'MaintenanceController@costPerType');
    Route::post('maintenances/report/cost/unit', 'MaintenanceController@costPerUnit');
    Route::post('maintenances/report/cost/department', 'MaintenanceController@costPerDepartment');
    Route::post('maintenances/report/cummulative', 'MaintenanceController@getCummulativeReport');
    Route::post('maintenances/report/categorized', 'MaintenanceController@getCategorizedReport');
    Route::post('maintenances/report/unit', 'MaintenanceController@getUnitReport');
    Route::post('maintenances/report/department', 'MaintenanceController@getDepartmentReport');
    Route::post('maintenances/report/cost/month', 'MaintenanceController@costPerMonth');
    Route::post('maintenances/report/cost/type', 'MaintenanceController@costPerType');
    Route::post('maintenances/report/cost/unit', 'MaintenanceController@costPerUnit');
    Route::post('maintenances/report/cost/department', 'MaintenanceController@costPerDepartment');
    Route::post('equipment/report/cummulative', 'EquipmentController@fetchCummulativeReport');
    Route::post('equipment/report/categorized', 'EquipmentController@fetchCategorizedReport');
    Route::post('equipment/report/unit', 'EquipmentController@fetchUnitReport');
    Route::post('equipment/report/department', 'EquipmentController@fetchDepartmentReport'); 
    
    

/*Route::prefix('maintenances')->group(function(){
    Route::get('/', 'MaintenanceController@index');
    Route::post('/add', 'MaintenanceController@store');
    Route::get('/{maintenance}', 'MaintenanceController@show');
    Route::put('/update/{maintenance}', 'MaintenanceController@update');
    Route::post('/report/cummulative', 'MaintenanceController@getCummulativeReport');
    Route::post('/report/categorized', 'MaintenanceController@getCategorizedReport');
    Route::post('/report/unit', 'MaintenanceController@getUnitReport');
    Route::post('/report/department', 'MaintenanceController@getDepartmentReport');
    Route::post('/report/cost/month', 'MaintenanceController@costPerMonth');
    Route::post('/report/cost/type', 'MaintenanceController@costPerType');
    Route::post('/report/cost/unit', 'MaintenanceController@costPerUnit');
    Route::post('/report/cost/department', 'MaintenanceController@costPerDepartment');
    Route::put('/approve', 'MaintenanceController@hospitalApprove');
    Route::put('/admin-approve', 'MaintenanceController@adminApprove');
});*/