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

Route::get('/','ContentController@getHome')->name('home');

// Modulo carrito de compras - Cart

Route::get('/cart','CartController@getCart')->name('cart');
Route::post('/cart','CartController@postCart')->name('cart');
Route::post('/cart/product/{id}/add','CartController@postCartAdd')->name('cart_add');
Route::post('/cart/item/{id}/update','CartController@postCartItemQuantityUpdate')->name('cart_item_update');
Route::get('/cart/item/{id}/delete', 'CartController@getCartItemDelete')->name('cart_item_delete'); // Eliminar galeria
Route::get('/cart/{order}/type/{type}','CartController@getOrderChangeType')->name('cart'); // Cambiar tipo de orden


 // Modulo de Store o tienda

Route::get('/store', 'StoreController@getStore')->name('store');
Route::get('/store/category/{id}/{slug}', 'StoreController@getCategory')->name('store_category');

 
 // Definimos rauter para autentificar

Route::get('/login', 'ConnectController@getLogin')->name('login');
Route::post('/login', 'ConnectController@postLogin')->name('login');
Route::get('/recover', 'ConnectController@getRecover')->name('recover');
Route::post('/recover', 'ConnectController@postRecover')->name('recover');
Route::get('/reset', 'ConnectController@getReset')->name('reset');
Route::post('/reset', 'ConnectController@postReset')->name('reset');
Route::get('/register', 'ConnectController@getRegister')->name('register');
Route::post('/register', 'ConnectController@postRegister')->name('register');
Route::get('/logout', 'ConnectController@getLogout')->name('logout');

// Modulo Productos

Route::get('/product/{id}/{slug}', 'ProductController@getProduct')->name('product_single');

// Modulo usuarios

Route::get('/account/edit', 'UserController@getAccountEdit')->name('account_edit');
Route::post('account/edit/avatar', 'UserController@postAccountAvatar')->name('account_avatar_edit');
Route::post('account/edit/password', 'UserController@postAccountPassword')->name('account_password_edit');
Route::post('account/edit/info', 'UserController@postAccountInfo')->name('account_info_edit');
Route::get('/account/address', 'UserController@getAccountAddress')->name('account_address'); // Direcciones de envió
Route::post('/account/address/add', 'UserController@postAccountAddressAdd')->name('account_address'); // Direcciones de envió
Route::get('/account/address/{address}/setdefault', 'UserController@getAccountAddressSetDefault')->name('account_address'); // Direcciones de envió principal
Route::get('/account/address/{address}/delete', 'UserController@getAccountAddressDelete')->name('account_address'); // Eliminar direcciones
Route::get('/account/history/orders', 'UserOrderController@getHistory')->name('account_user_orders_history'); // Historial de compras
Route::get('/account/history/order/{order}', 'UserOrderController@getOrder')->name('account_user_order_details'); // Historial de compras

// Ajax route api

Route::get('/md/api/load/products/{section}', 'ApiJsController@getProductsSection');
Route::post('/md/api/load/user/favorites' , 'ApiJsController@postUserFavorites');
Route::post('/md/api/favorites/add/{object}/{module}', 'ApiJsController@postFavoriteAdd');
Route::post('/md/api/load/product/inventory/{inv}/variants', 'ApiJsController@postProductInventoryVartiants'); // Cargar variantes
Route::post('/md/api/load/cities/{state}', 'ApiJsController@postCoverageCitiesFromState'); // Cargar ciudades


