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


Route::get('/', function () {
	if (Auth::user()) {

        return Redirect::to("/dashboard");

    } else {
        return view('auth.login');
    }
});

Route::get('/login', function () {
	if (Auth::user()) {

        return Redirect::to("/dashboard");

    } else {
        return view('auth.login');
    }
});


Auth::routes();

/*dashboard*/
Route::get('/dashboard', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/admin', 'AdminController@index');
Route::get('/cashier', 'CashierController@index');
Route::get('/waiter', 'WaiterController@index');
Route::get('/kitchen', 'KitchenController@index');

/*Profile*/
Route::get('/profile', 'ProfileController@index');
Route::get('user/profile/edit', 'ProfileController@edituser');
Route::get('user/password', 'ProfileController@changepassword');
Route::get('admin/profile', 'ProfileController@admin');
Route::get('admin/profile/edit', 'ProfileController@editadmin');
Route::get('admin/password', 'ProfileController@adminpassword');
Route::post('user/profile/update', 'ProfileController@updateuser');
Route::post('user/password/update', 'ProfileController@updatepassword');

/*food category*/
Route::get('/category', 'CategoryController@index');
Route::get('/category/create', 'CategoryController@create');
Route::post('/category/store', 'CategoryController@store');
Route::get('/category/edit/{id}', 'CategoryController@edit');
Route::post('/category/update/{id}', 'CategoryController@update');
Route::get('/category/show/{id}', 'CategoryController@show');
Route::get('/category/delete/{id}', 'CategoryController@destroy');
Route::get('/category/view/food/{id}', 'CategoryController@foodtemplate');
Route::get('/category/report', 'CategoryController@report');
Route::post('/category/report', 'CategoryController@getreport');
Route::get('/category/individual/report/{id}', 'CategoryController@individualreport');
Route::post('/category/individual/report/{id}', 'CategoryController@getindividualreport');
Route::get('/admin/view/food/{id}', 'AdminController@foodtemplate');
Route::post('/getprices', 'CategoryController@getprices');
Route::post('/results', 'CategoryController@results');

/*food*/
Route::get('/food', 'FoodController@index');
Route::get('/food/create', 'FoodController@create');
Route::post('/food/store', 'FoodController@store');
Route::get('/food/edit/{id}', 'FoodController@edit');
Route::post('/food/update/{id}', 'FoodController@update');
Route::get('/food/show/{id}', 'FoodController@show');
Route::get('/food/delete/{id}', 'FoodController@destroy');
Route::get('/food/report', 'FoodController@report');
Route::post('/food/report', 'FoodController@getreport');
Route::get('/food/individual/report/{id}', 'FoodController@individualreport');
Route::post('/food/individual/report/{id}', 'FoodController@getindividualreport');

/*settings*/
Route::get('/setting', 'SettingsController@index');
Route::post('/setting/update', 'SettingsController@update');
Route::get('/setting/individual/report/{id}', 'SettingsController@individualreport');
Route::post('/setting/individual/report/{id}', 'SettingsController@getindividualreport');

/*users*/
Route::get('/users', 'UsersController@index');
Route::get('/users/create', 'UsersController@create');
Route::post('/users/store', 'UsersController@store');
Route::get('/users/edit/{id}', 'UsersController@edit');
Route::post('/users/update/{id}', 'UsersController@update');
Route::get('/users/show/{id}', 'UsersController@show');
Route::get('/users/delete/{id}', 'UsersController@destroy');
Route::get('/users/deactivate/{id}', 'UsersController@deactivate');
Route::get('/users/activate/{id}', 'UsersController@activate');
Route::get('/users/changepassword/{id}', 'UsersController@changepassword');
Route::post('/users/changepassword/{id}', 'UsersController@updatepassword');
Route::get('/users/report', 'UsersController@report');
Route::post('/users/report', 'UsersController@getreport');
Route::get('/users/individual/report/{id}', 'UsersController@individualreport');
Route::post('/users/individual/report/{id}', 'UsersController@getindividualreport');

/*orders*/
Route::post('/send', 'WaiterController@send');
Route::get('/waiter/orders/', 'WaiterController@orders');
Route::get('/waiter/summary/', 'WaiterController@summary');
Route::get('/admin/summary/', 'AdminController@summary');
Route::get('/order/show/{id}', 'WaiterController@orderitems');
Route::get('/kitchen/order/show/{id}', 'KitchenController@orderitems');
Route::get('/kitchen/order/complete/{id}', 'KitchenController@completeorder');
Route::get('/kitchen/order/complete/{id}', 'KitchenController@completeorder');
Route::get('/kitchen/order/return/{id}', 'KitchenController@returnorder');
Route::get('/kitchen/order/uncomplete/{id}', 'KitchenController@uncompleteorder');
Route::get('/kitchen/orderitem/cancel/{id}', 'KitchenController@cancelorderitem');
Route::get('/kitchen/order/cancel/{id}', 'KitchenController@cancelorder');
Route::get('/orders/complete', 'KitchenController@completekitchenorder');
Route::get('/orders/pending', 'KitchenController@pendingkitchenorder');
Route::get('/orders/cancelled', 'KitchenController@cancelledkitchenorder');
Route::get('/neworders', 'KitchenController@neworders');
Route::get('/admin/orders', 'AdminController@orders');
Route::get('/admin/order/show/{id}', 'AdminController@orderitems');
Route::get('/admin/orderitem/cancel/{id}', 'AdminController@cancelorderitem');
Route::get('/waiter/orderitem/cancel/{id}', 'WaiterController@cancelorderitem');
Route::get('/admin/orderitem/return/{id}', 'AdminController@returnorderitem');
Route::get('/waiter/orderitem/return/{id}', 'WaiterController@returnorderitem');
Route::get('/getneworders', 'KitchenController@getneworders');
Route::get('/updatebeep', 'KitchenController@updatebeep');
Route::get('/cashier/order/show/{id}', 'CashierController@orderitems');
Route::get('/cashier/paid/orders', 'CashierController@paidorders');
Route::get('/cashier/pending/orders', 'CashierController@pendingorders');
Route::get('/cashier/order/transact/{id}', 'CashierController@transact');
Route::post('/cashier/order/transact/{id}', 'CashierController@dotransact');
Route::get('/cashier/order/reverse/{id}', 'CashierController@reverse');
Route::get('/admin/orders/report', 'AdminController@report');
Route::post('/admin/orders/report', 'AdminController@getreport');
Route::get('/admin/orders/individual/report/{id}', 'AdminController@individualreport');
Route::post('/admin/orders/individual/report/{id}', 'AdminController@getindividualreport');
Route::get('/receipt/{id}', 'WaiterController@receipt');
Route::get('/admin/orders/payments', 'AdminController@payments');
Route::get('/admin/orders/payments/report', 'AdminController@paymentsreport');
Route::post('/admin/orders/payments/report', 'AdminController@getpaymentsreport');
Route::get('/cashier/orders/report', 'CashierController@report');
Route::post('/cashier/orders/report', 'CashierController@getreport');
Route::get('/cashier/paid/orders/report', 'CashierController@paidreport');
Route::post('/cashier/paid/orders/report', 'CashierController@getpaidreport');
Route::get('/cashier/pending/orders/report', 'CashierController@pendingreport');
Route::post('/cashier/pending/orders/report', 'CashierController@getpendingreport');
Route::get('/cashier/orders/individual/report/{id}', 'CashierController@individualreport');
Route::get('/waiter/orders/individual/report/{id}', 'WaiterController@individualreport');
Route::get('/waiter/orders/report', 'WaiterController@report');
Route::post('/waiter/orders/report', 'WaiterController@getreport');
Route::get('/waiter/summary/report', 'WaiterController@summaryreport');
Route::post('/waiter/summary/report', 'WaiterController@getsummaryreport');
Route::get('/waiter/today/orders/report', 'WaiterController@todayreport');
Route::post('/waiter/today/orders/report', 'WaiterController@gettodayreport');
Route::get('/kitchen/orders/individual/report/{id}', 'KitchenController@individualreport');
Route::get('/kitchen/orders/report', 'KitchenController@report');
Route::post('/kitchen/orders/report', 'KitchenController@getreport');

Route::get('/admin/summary/report', 'AdminController@summaryreport');
Route::post('/admin/summary/report', 'AdminController@getsummaryreport');
Route::get('/admin/user/summary/{id}', 'AdminController@usersummary');
Route::get('/admin/user/summary/report/{id}', 'AdminController@usersummaryreport');
Route::post('/admin/user/summary/report/{id}', 'AdminController@getusersummaryreport');
