<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','ItemController@index');
Route::get('/support', function () {
    return view('items.support');
});
Route::get('/myaccount', function () {
    return view('items.myaccount');
});
Route::get('/contact', function () {
    return view('items.contact');
});

Route::get('/showproducts/{category_id}','ItemController@getTopItemsByCategory');
Route::get('/item/{item_name}','ItemController@getByItemName');
Route::get('/addtocart/{item_id}','ItemController@addToCart');
Route::get('/removefromcart/{array_index}','ItemController@removeFromCart');
Route::get('/cart','ItemController@showCart');
