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
    return view('welcome');
});

Auth::routes();

Route::post('login', 'API\UserController@login');

Route::post('register', 'API\UserController@register');


Route::group(['middleware' => 'auth:api'], function(){

	Route::post('details', 'API\UserController@details');

});


//Route::get('/home', 'HomeController@index')->name('home');

//Route::auth();

Route::group(['middleware' => ['auth']], function() {

	Route::get('blog', 'FrontController@index');

	Route::get('/home', 'HomeController@index');

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

	Route::get('itemCRUD2',['as'=>'itemCRUD2.index','uses'=>'ItemCRUD2Controller@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
	Route::get('itemCRUD2/create',['as'=>'itemCRUD2.create','uses'=>'ItemCRUD2Controller@create','middleware' => ['permission:item-create']]);
	Route::post('itemCRUD2/create',['as'=>'itemCRUD2.store','uses'=>'ItemCRUD2Controller@store','middleware' => ['permission:item-create']]);
	Route::get('itemCRUD2/{id}',['as'=>'itemCRUD2.show','uses'=>'ItemCRUD2Controller@show']);
	Route::get('itemCRUD2/{id}/edit',['as'=>'itemCRUD2.edit','uses'=>'ItemCRUD2Controller@edit','middleware' => ['permission:item-edit']]);
	Route::patch('itemCRUD2/{id}',['as'=>'itemCRUD2.update','uses'=>'ItemCRUD2Controller@update','middleware' => ['permission:item-edit']]);
	Route::delete('itemCRUD2/{id}',['as'=>'itemCRUD2.destroy','uses'=>'ItemCRUD2Controller@destroy','middleware' => ['permission:item-delete']]);

	Route::get('/products','FrontController@products');
	Route::get('/products/details/{id}','FrontController@product_details');
	Route::get('/products/categories/{name}','FrontController@product_categories');
	Route::get('/products/brands/{name}/{category?}','FrontController@product_brands');
	Route::get('/blog','FrontController@blog');
	Route::get('/blog/post/{id}','FrontController@blog_post');
	Route::get('/contact-us','FrontController@contact_us');
	//Route::get('/login','FrontController@login');
	//Route::get('/logout','FrontController@logout');
	Route::get('/cart','FrontController@cart');
	Route::post('/cart','FrontController@cart');
	Route::get('/checkout','FrontController@checkout');
	Route::get('/search/{query}','FrontController@search');

	Route::get('blade', function () {
	    $drinks = array('Vodka','Gin','Brandy');
	    return view('page',array('name' => 'The Raven','day' => 'Friday','drinks' => $drinks));
	});
});
