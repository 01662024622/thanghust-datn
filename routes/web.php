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

Route::post('addToCart', 'WareHousingController@addToCart');
Route::post('createOrder', 'WareHousingController@createOrder');
Route::delete('orderDelete/{id}', 'WareHousingController@orderDelete');
Route::delete('deleteAll', 'WareHousingController@deleteAll');

Route::get('/','FontEndController@index');
Route::get('posts/{slug}', 'FontEndController@posts');

Auth::routes();
// Route::group(['prefix' => 'admin'], function() {
Route::middleware('auth')->group(function(){
        Route::get('/orders', 'HomeController@index')->name('home');
        Route::get('userOder', 'HomeController@anyData')->name('userOder.data');
        Route::get('getOrder/{id}', 'HomeController@getOrder');
        Route::delete('deleteOrder/{id}', 'HomeController@deleteOrder');
});





Route::post('posts/addCustom', 'FontEndController@addCustom');
Route::post('getColor', 'FontEndController@getColor');
Route::post('getSize', 'FontEndController@getSize');
Route::post('getColor-one', 'FontEndController@getColor_one');
Route::post('getSize-one', 'FontEndController@getSize_one');





		/*
		*
		* manage login admin
		*@param  
		*@param  
		*@return 
		*/
                Route::group(['prefix'=>'admin'],function(){
                        Route::middleware('admin')->group(function(){
                                Route::get('anyData', 'ProductController@anyData')->name('datatables.data');
                                Route::get('products', 'ProductController@index');
                                Route::get('/', 'ProductController@index');
                                Route::get('product/plus/{id}', 'ProductController@plusData');
                                Route::get('getProduct/{id}', 'ProductController@getProduct');
                                Route::post('product/store', 'ProductController@store');
                                Route::post('product/update', 'ProductController@updateProduct');
                                Route::delete('product/{id}', 'ProductController@destroy');

                                Route::post('wareHousing/storewareHousing', 'WareHousingController@storewareHousing');
                                Route::get('wareHousing/{id}', 'WareHousingController@wareHousing');
                                Route::delete('wareHousingDelete/{id}', 'WareHousingController@destroy');




                                Route::get('anyUser', 'UserController@anyData')->name('users.data');
                                Route::get('users', 'UserController@index');
                                Route::get('user/edit/{id}', 'UserController@getData');
                                Route::post('users/store', 'UserController@store');
                                Route::delete('user/{id}', 'UserController@destroy');
                                Route::get('user/status/{id}', 'UserController@status');
                                Route::post('users/update', 'UserController@updateUser');

                                Route::get('anyCategory', 'CategoryController@anyData')->name('categories.data');
                                Route::get('categories', 'CategoryController@index');
                                Route::get('categories/edit/{id}', 'CategoryController@getData');
                                Route::post('categories/store', 'CategoryController@store');
                                Route::delete('categories/{id}', 'CategoryController@destroy');
                                Route::post('categories/update', 'CategoryController@updateData');



                                Route::get('anyTables', 'TableController@anyData')->name('tables.data');
                                Route::get('tables', 'TableController@index');
                                Route::post('tables/store', 'TableController@store');
                                Route::delete('tables/{id}', 'TableController@destroy');


                                Route::get('anyColor', 'ColorController@anyData')->name('color.data');
                                Route::get('colors', 'ColorController@index');
                                Route::get('color/edit/{id}', 'ColorController@getData');
                                Route::post('color/store', 'ColorController@store');
                                Route::delete('color/{id}', 'ColorController@destroy');
                                Route::post('color/update', 'ColorController@updateData');


                                Route::get('anySize', 'SizeController@anyData')->name('size.data');
                                Route::get('sizes', 'SizeController@index');
                                Route::get('size/edit/{id}', 'SizeController@getData');
                                Route::post('size/store', 'SizeController@store');
                                Route::delete('size/{id}', 'SizeController@destroy');
                                Route::post('size/update', 'SizeController@updateData');

                // Route::post('users/{slug}', 'UserController@manageUser');

                                Route::get('orders', 'OrderController@index')->name('home');
                                Route::get('adminorder', 'OrderController@anyData')->name('adminOder.data');
                                Route::get('getOrder/{id}', 'OrderController@getOrder');
                                Route::delete('deleteOrder/{id}', 'OrderController@deleteOrder');

                // });


                        });


Route::get('login', 'Admin\LoginController@showLoginForm');
Route::post('login', 'Admin\LoginController@login')->name('admin.login');
Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

        // Registration Routes...
Route::get('register', 'Admin\AdminRegisterController@showRegistrationForm')->name('admin.register');
Route::post('register', 'Admin\AdminRegisterController@register');

        // // Password Reset Routes...
Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Admin\ResetPasswordController@reset');

});