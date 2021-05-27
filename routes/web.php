<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
	'prefix' => '/',
	'namespace' => 'App\Http\Controllers\Admin'
], function() {
	Route::match(['get', 'post'], '/', 'AuthController@login');

	Route::group(['middleware' => ['admin']], function() {

		Route::match(['get', 'put'], 'profile', 'AuthController@profile');
		Route::get('logout', 'AuthController@logout');
		Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
		Route::get('pos', 'PointOfSaleController@index')->name('pos.index');
		Route::get('pos/search_order/{orderid}', 'PointOfSaleController@searchOrder')->name('pos.search_order');
		Route::post('pos/process_order', 'PointOfSaleController@processOrder')->name('pos.process_order');
		Route::resource('history', 'HistoryController');

		Route::group([
			'middleware' => [], 
			'as' => 'master.', 
			'prefix' => 'master', 
			'namespace' => 'Master'
		], function() {
		    Route::resource('tenant', 'TenantController')->middleware(['permission:tenant']);
		});

		Route::group([
			'middleware' => ['role:super-admin'], 
			'as' => 'administrator.', 
			'prefix' => 'administrator', 
			'namespace' => 'Administrator'
		], function() {
		    Route::resource('user', 'UserController');
		    Route::resource('permission', 'PermissionController')->middleware(['role:super-admin']);
		    Route::resource('role', 'RoleController')->middleware(['role:super-admin']);
		});

		Route::group([
			'middleware' => [], 
			'as' => 'report.', 
			'prefix' => 'report', 
			'namespace' => 'Report'
		], function() {
		    Route::get('report_order', 'ReportController@index')->middleware(['permission:report_order'])->name('order.index');
		    Route::post('report_order', 'ReportController@view')->middleware(['permission:report_order'])->name('order.view');
		    Route::get('export_report_order', 'ReportController@export')->middleware(['permission:report_order'])->name('order.export');
		    Route::get('order_tenant', 'ReportController@getTenant')->name('order.tenant');
		});
	});
});
