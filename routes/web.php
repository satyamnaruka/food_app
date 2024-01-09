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


	Route::get('/', "HomeController@index");
 
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\LoginController@login')->name('login'); 

	Route::match(['get','post'],'/change-password', 'Admin\AdminController@changePassword')->name('changepassword');
 
	Route::group(['prefix'=>'admin','as'=>'admin','middleware'=>['auth','checkadmin'],'as'=>'admin.'],function() {
		
		Route::match(['get','post'],'/logout','Auth\LoginController@logout')->name('logout');
		Route::match(['get','post'],'/dashboard', 'Admin\DashboardController@index');
 
		Route::group(['prefix'=>'user'],function() {
			Route::get('/list', 'Admin\UserController@userList');
			Route::post('block-user','Admin\UserController@blockUser')->name('user.block');
			Route::get('update/{id}','Admin\UserController@updateUser');
			Route::post('update-user','Admin\UserController@updateUserEnd');
			Route::post('get-states-byCountryId','Admin\UserController@getStateByCountryId')->name('getStates-byCountryId');
			Route::post('get-city-by-stateId','Admin\UserController@getCityByStateId')->name('getCity-byStateId');
		});	

		// slider list
		Route::group(['prefix'=>'slider'],function() {
			Route::match(['get','post'],'add', 'Admin\SliderController@add')->name('slider.add');
			Route::get('list', 'Admin\SliderController@sliderList')->name('slider.list');
			Route::post('change-status','Admin\SliderController@changeStatus')->name('slider.changeStatus');
			Route::get('update/{id}','Admin\SliderController@updateSlider');
			Route::get('delete/{id}','Admin\SliderController@deleteSlider');
			Route::post('change-order','Admin\SliderController@changeOrder')->name('slider.changeOrder');

		});

		Route::group(['prefix'=>'category'],function(){
			Route::match(['get','post'],'add','Admin\CategoryController@add')->name('category.add');
			Route::get('list','Admin\CategoryController@list')->name('category.list');
			Route::get('update/{id}', 'Admin\CategoryController@update')->name('category.update');
			Route::get('delete/{id}', 'Admin\CategoryController@delete')->name('category.delete');
			Route::post('change-status', 'Admin\CategoryController@status')->name('category.changeStatus');
		});

		Route::group(['prefix'=>'product'],function(){
			Route::match(['get','post'],'add','Admin\ProductController@add')->name('product.add');
			Route::get('list','Admin\ProductController@list')->name('product.list');
			Route::get('update/{id}', 'Admin\ProductController@update')->name('product.update');
			Route::get('delete/{id}', 'Admin\ProductController@delete')->name('product.delete');
			Route::post('change-status', 'Admin\ProductController@changeStatus')->name('product.changeStatus');
			
			
		});
	});


	Route::match(['get','post'],'/logout','Auth\LoginController@logout')->name('logout');
