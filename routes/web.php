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



Auth::routes();
// Route::group(['prefix' => 'admin'], function() {


Route::middleware('logined')->group(function(){
        Route::get('/', 'WorkingController@index');
        Route::get('/location/{location}', 'WorkingController@location');

        Route::get('/table/{table}', 'WorkingController@table');
        Route::get('/add/{table}/{id}', 'WorkingController@cart');
        Route::get('/minus/{table}/{id}', 'WorkingController@cartminus');
        Route::post('/status/table/user/{code}', 'WorkingController@tableStatus');
        Route::post('/status/table/cashier/{code}', 'WorkingController@orderStatus');
        Route::get('/pay/product/{id}', 'WorkingController@payProduct');
        Route::get('/payment/proposal/{id}', 'WorkingController@paymentProposal');

        Route::get('/anyDataUser/{category}/{tale}', 'ProductController@anyDataUser')->name('datatables.anyDataUser');

        Route::get('/anyData/waits/table/{id}', 'WorkingController@dataWait')->name('datatables.waits');
        Route::get('/anyData/bill/table/{id}', 'WorkingController@dataBill')->name('datatables.bills');

        Route::get('/chef/anyData/', 'ChefController@dataChef');
        Route::get('/chef', 'ChefController@index');
        Route::get('/chef/order/{id}', 'ChefController@changeStatus');

        Route::get('/cashier/anyData/', 'ChefController@dataCashier');
        Route::get('/anyData/order/bill/{id}', 'ChefController@orderBill');
        Route::get('/cashier', 'ChefController@cashier');
        Route::get('/cashier/order/{id}', 'ChefController@payment');
});



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
                Route::post('product/add/quantity/{id}', 'ProductController@addQuantity');




                Route::get('anyUser', 'UserController@anyData')->name('users.data');
                Route::get('users', 'UserController@index');
                Route::get('user/edit/{id}', 'UserController@getData');
                Route::post('users/store', 'UserController@store');
                Route::delete('user/{id}', 'UserController@destroy');
                Route::get('user/status/{id}', 'UserController@status');
                Route::post('users/update', 'UserController@updateUser');
                Route::post('/api/status/users/{id}', 'UserController@usersStatus');

                Route::get('anyCategory', 'CategoryController@anyData')->name('categories.data');
                Route::get('categories', 'CategoryController@index');
                Route::get('categories/edit/{id}', 'CategoryController@getData');
                Route::post('categories/store', 'CategoryController@store');
                Route::delete('categories/{id}', 'CategoryController@destroy');
                Route::post('categories/update', 'CategoryController@updateData');


                Route::get('anyCoupon', 'CouponController@anyData')->name('coupons.data');
                Route::get('coupons', 'CouponController@index');
                Route::get('coupons/edit/{id}', 'CouponController@getData');
                Route::post('coupons/store', 'CouponController@store');
                Route::delete('coupons/{id}', 'CouponController@destroy');
                Route::post('coupons/update', 'CouponController@updateData');



                Route::get('anyTables', 'TableController@anyData')->name('tables.data');
                Route::get('tables', 'TableController@index');
                Route::post('tables/store', 'TableController@store');
                Route::delete('tables/{id}', 'TableController@destroy');



                // Route::post('users/{slug}', 'UserController@manageUser');

                Route::get('orders', 'OrderController@index')->name('home');
                Route::get('adminorder', 'OrderController@anyData')->name('adminOder.data');
                Route::get('getOrder/{id}', 'OrderController@getOrder');
                Route::delete('deleteOrder/{id}', 'OrderController@deleteOrder');
                
                Route::get('/anyData/order/bill/{id}', 'ChefController@orderBill');

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